<?php

namespace App\Http\Controllers;

use App\Models\Prof;
use Illuminate\Http\Request;
use App\Models\ClassList;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Requests;



class ProfessorController extends Controller
{
    public function index()
    {
        $professors = Prof::paginate(10);
        return view('professors.index', compact('professors'));
    }

    public function create()
    {
        // Fetch all classes that do not have a professor assigned
        $classes = ClassList::doesntHave('professor')->get();

        return view('professors.create', compact('classes'));
    }


    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'prof_number' => 'required|string|max:255|unique:profs,prof_number',
            'nip' => 'required|string|max:255|unique:profs,nip',
            'classes' => 'nullable|array', // Validate that classes is an array
            'classes.*' => 'exists:classlists,id', // Ensure each selected class ID exists
        ]);

        // Create the User
        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'prof', // Assign the 'professor' role
        ]);

        // Create the Professor
        $professor = Prof::create([
            'user_id' => $user->id, // Link the user ID to the professor
            'name' => $request->name, // Add the name field for the professor
            'prof_number' => $request->prof_number,
            'nip' => $request->nip,
        ]);

        // Attach the selected classes to the professor, if any are selected
        if ($request->filled('classes')) {
            $professor->classes()->attach($request->classes);
        }

        // Redirect to the professors index with a success message
        return redirect()->route('professors.index')->with('success', 'Professor created successfully.');
    }



    public function edit($id)
    {
        // Fetch the professor by ID
        $professor = Prof::findOrFail($id);

        // Fetch all classes
        // Fetch classes assigned to other professors
        $assignedClassIds = Prof::where('id', '!=', $id)->with('classes')->get()->pluck('classes.*.id')->flatten()->unique()->toArray();

        // Get classes that are not assigned to any professor
        $classes = ClassList::whereNotIn('id', $assignedClassIds)->get();

        // Fetch classes that are assigned to this professor
        $assignedClasses = $professor->classes->pluck('id')->toArray();

        return view('professors.edit', compact('professor', 'classes', 'assignedClasses'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prof_number' => 'required|string|max:255',
            'nip' => 'required|string|max:255',
            'classes' => 'array', // Validate that classes is an array
            'classes.*' => 'exists:classlists,id', // Ensure each selected class ID exists
        ]);

        $professor = Prof::findOrFail($id);

        // Update the professor details
        $professor->update([
            'name' => $request->input('name'),
            'prof_number' => $request->input('prof_number'),
            'nip' => $request->input('nip'),
        ]);

        // Get the list of class IDs that should be assigned to the professor
        $newClassIds = $request->input('classes', []);

        // Update the `prof_id` in the `classlists` table
        ClassList::where('prof_id', $professor->id)->update(['prof_id' => null]); // Detach all classes from this professor
        ClassList::whereIn('id', $newClassIds)->update(['prof_id' => $professor->id]); // Attach selected classes

        return redirect()->route('professors.show', $professor->id)
            ->with('success', 'Professor updated successfully.');
    }




    public function destroy($id)
    {
        // Find professor by ID or fail
        $professor = Prof::findOrFail($id);

        // Begin a transaction to ensure both deletions happen atomically
        DB::transaction(function () use ($professor) {
            // Delete the associated user
            $professor->user->delete();

            // Delete the professor
            $professor->delete();
        });

        // Redirect with success message
        return redirect()->route('professors.index')->with('success', 'Professor and associated user deleted successfully.');
    }


    public function show($id)
    {
        // Find professor by ID or fail
        $professor = Prof::findOrFail($id);
        return view('professors.show', compact('professor'));
    }

    public function requestList()
    {
        $professor = Auth::user()->prof;

        if (!$professor) {
            return redirect()->route('home')->withErrors('Professor record not found.');
        }

        $requests = Requests::whereHas('class', function ($query) use ($professor) {
            $query->where('prof_id', $professor->id);
        })->get();

        return view('professors.requestlist', compact('requests'));
    }

    public function requestDetails($id)
    {
        $request = Requests::with('class.professor')->findOrFail($id);
        $professor = Auth::user()->prof;

        // Debugging statements
        if (!$request->class) {
            abort(404, 'Class not found.');
        }

        if ($request->class->prof_id != $professor->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('professors.requestDetails', compact('request'));
    }


    public function denyRequest($id)
    {
        $request = Requests::findOrFail($id);
        $professor = Auth::user()->prof;

        if ($request->class->prof_id != $professor->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->status = 'denied';
        $request->save();

        return redirect()->route('professors.requestList')
            ->with('success', 'Request has been denied.');
    }

    public function grantRequest($id)
    {
        $request = Requests::findOrFail($id);
        $professor = Auth::user()->prof;

        if ($request->class->prof_id != $professor->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->status = 'granted';
        $request->save();

        // Allow the student to edit their data
        $student = $request->student;
        $student->edit = true;
        $student->save();

        return redirect()->route('professors.requestList')
            ->with('success', 'Request has been granted and the student can now edit their data.');
    }
}
