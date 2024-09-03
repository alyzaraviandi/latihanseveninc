<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\ClassList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request as HttpRequest;
use App\Models\Requests;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    private function professorClasses()
    {
        $user = Auth::user();

        if ($user && $user->role === 'prof' && $user->prof) {
            $classIds = $user->prof->classes->pluck('id')->toArray();

            return $classIds;
        }

        return [];
    }

    public function index()
    {
        $user = Auth::user();
        $professorClassIds = $this->professorClasses();

        if ($user->role === 'head') {
            // Fetch all students for 'head'
            $students = Student::with('classes')->latest()->paginate(10);
        } elseif ($user->role === 'prof') {
            // Fetch students only in the classes managed by the professor
            $students = Student::whereHas('classes', function ($query) use ($professorClassIds) {
                $query->whereIn('classlists.id', $professorClassIds); // Specify table name
            })->with('classes')
                ->latest()
                ->paginate(10);
        } else {
            // Handle other roles or unauthorized access
            abort(403, 'Unauthorized access');
        }

        return view('students.index', [
            'students' => $students
        ]);
    }

    public function create()
    {
        $user = Auth::user();

        // Check if the user is 'head'
        if ($user->role !== 'head') {
            abort(403, 'Unauthorized access.');
        }

        // Check for the session flash data
        if (session()->has('student_created')) {
            Log::info('Redirecting to index due to flash session data');
            return redirect()->route('students.index');
        }

        // 'head' role can access all classes
        $classes = ClassList::withCount('students')->get(); // Get class capacity info

        // Log the classes data
        Log::info('Rendering create view with classes:', $classes->toArray());

        return response()
            ->view('students.create', compact('classes'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }


    public function store(Request $request)
    {
        $user = Auth::user();
        $classIds = $this->professorClasses();

        Log::info('Storing student with request data:', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'student_number' => 'required|string|max:255|unique:students,student_number',
            'classes' => 'array',
            'classes.*' => ['exists:classlists,id', function ($attribute, $value, $fail) use ($classIds, $user) {
                if ($user->role !== 'head' && !in_array($value, $classIds)) {
                    Log::warning("Validation failed: Class ID {$value} is not managed by the professor.");
                    $fail('The selected class is not managed by your professor.');
                }
            }],
        ]);

        // Check if any of the selected classes are full
        $selectedClasses = ClassList::whereIn('id', $request->classes)
            ->withCount('students')
            ->get();

        foreach ($selectedClasses as $class) {
            if ($class->students_count >= $class->sum) {
                Log::warning("Class ID {$class->id} is full. Cannot add more students.");
                return redirect()->back()->withErrors(['classes' => 'One or more selected classes are full.'])->withInput();
            }
        }

        // Create the user and student
        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'student',
        ]);

        Log::info("User created with ID: {$user->id}");

        $student = Student::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'student_number' => $request->student_number,
        ]);

        Log::info("Student created with ID: {$student->id}");

        $student->classes()->attach($request->classes);
        Log::info("Student ID {$student->id} assigned to classes:", $request->classes);

        // Set session flash data
        session()->flash('student_created', true);
        Log::info('Flash session data set: student_created');

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }


    public function edit($id)
    {
        $user = Auth::user();
        $student = Student::findOrFail($id);
        $classes = collect();  // Initialize $classes as an empty collection

        // Ensure the student can be edited if the user is the student themselves
        if ($user->role === 'student' && ($student->user_id !== $user->id || !$student->edit)) {
            return redirect()->back()->withErrors(['error' => 'You do not have permission to update this student.']);
        }

        if ($user->role === 'prof') {
            $classIds = $this->professorClasses();
            $classes = ClassList::whereIn('id', $classIds)->withCount('students')->get();

            // Ensure the student is in a class managed by the professor
            if (!$student->classes->pluck('id')->intersect($classIds)->isNotEmpty()) {
                abort(403, 'You do not have permission to edit this student.');
            }
        } else if ($user->role === 'head') {
            // 'head' role can access all classes
            $classes = ClassList::withCount('students')->get();
        } else if ($user->role === 'student') {
            // If the user is a student, they should be able to see only the classes they are enrolled in
            $classes = $student->classes()->withCount('students')->get();
        }

        return view('students.edit', compact('student', 'classes'));
    }


    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $student = Student::findOrFail($id);

        if (!$student->edit && $user->role === 'student') {
        }

        if ($user->role === 'student' && $student->user_id !== $user->id) {
            return redirect()->back()->withErrors(['error' => 'You do not have permission to update this student.']);
        }

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'classes' => 'array',
            'classes.*' => ['exists:classlists,id', function ($attribute, $value, $fail) use ($user) {
                if ($user->role === 'prof' && !in_array($value, $this->professorClasses())) {
                    $fail('The selected class is not managed by your professor.');
                }
            }],
        ]);

        // Ensure the student is in a class managed by the professor if the user is a professor
        if ($user->role === 'prof' && !$student->classes->pluck('id')->intersect($this->professorClasses())->isNotEmpty()) {
            abort(403, 'You do not have permission to update this student.');
        }

        // Update the student
        $student->update($request->only(['name', 'place_of_birth', 'date_of_birth']));

        // Check if any of the updated classes exceed their capacity
        $selectedClasses = ClassList::whereIn('id', $request->input('classes'))
            ->withCount('students')
            ->get();

        foreach ($selectedClasses as $class) {
            if ($class->students_count > $class->sum) {
                return redirect()->back()->withErrors(['classes' => 'One or more selected classes exceed their capacity.'])->withInput();
            }
        }

        $student->classes()->sync($request->input('classes'));

        // Check if the request is from the student themselves
        if ($user->role === 'student' && $student->user_id === $user->id) {
            $requestRecord = Requests::where('student_id', $student->id)
                ->where('status', 'granted')
                ->first();

            if ($requestRecord) {
                $requestRecord->delete();

                $student->edit = false;
                $student->save();
            }
        }

        return redirect()->route('students.show', $student->id)
            ->with('success', 'Student updated successfully.');
    }

    public function show($id)
    {
        $user = Auth::user();
        $student = Student::findOrFail($id);

        if ($user->role === 'prof' && !$student->classes->pluck('id')->intersect($this->professorClasses())->isNotEmpty()) {
            abort(403, 'You do not have permission to view this student.');
        }

        return view('students.show', compact('student'));
    }

    public function destroy($id)
    {
        $user = Auth::user();

        // Check if the user is 'head'
        if ($user->role !== 'head') {
            abort(403, 'Unauthorized access.');
        }

        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student and associated user deleted successfully.');
    }

    public function profile()
    {
        $student = Auth::user()->student;
        return view('students.profile', compact('student'));
    }

    public function storeRequest(Request $request, $id)
    {
        $validatedData = $request->validate([
            'class_id' => 'required|exists:classlists,id',
            'info' => 'required|string|max:255',
        ]);

        $student = Student::findOrFail($id);

        $studentRequest = new Requests();
        $studentRequest->student_id = $student->id;
        $studentRequest->class_id = $validatedData['class_id'];
        $studentRequest->info = $validatedData['info'];
        $studentRequest->status = 'pending'; // Set default status
        $studentRequest->save();

        return redirect()->route('students.requestList', ['id' => $id])
            ->with('success', 'Your request has been submitted successfully.');
    }


    public function requestEditForm($id)
    {
        $student = Student::findOrFail($id);
        $classes = $student->classes;

        return view('students.request', compact('student', 'classes'));
    }

    public function showRequestList()
    {
        $student = Auth::user()->student;

        if (!$student) {
            return redirect()->route('students.profile')->with('error', 'Student profile not found.');
        }

        $requests = $student->requests;

        return view('students.requestlist', compact('student', 'requests'));
    }


    public function showRequestDetails($id)
    {
        // Find the request by ID, or fail if not found
        $request = Requests::findOrFail($id);

        // Fetch the associated class and professor
        $class = $request->class; // Assuming 'class' is the correct method name
        $professor = $class->professor ?? null; // Fetch professor if available

        // Return the view with the request, class, and professor
        return view('students.requestDetails', compact('request', 'class', 'professor'));
    }

    public function deleteRequest($id)
    {
        // Find the request by ID
        $request = Requests::findOrFail($id);

        // Ensure the request belongs to the authenticated student
        if ($request->student_id != Auth::user()->student->id) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure the request can only be deleted if its status is denied
        if ($request->status != 'denied') {
            return redirect()->route('students.requestList')->with('error', 'You can only delete denied requests.');
        }

        // Delete the request
        $request->delete();

        // Redirect back to the request list with a success message
        return redirect()->route('students.requestList')->with('success', 'Request deleted successfully.');
    }
}
