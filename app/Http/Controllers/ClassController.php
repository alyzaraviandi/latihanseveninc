<?php

namespace App\Http\Controllers;

use App\Models\ClassList;
use Illuminate\Http\Request;
use App\Models\Prof;
use App\Models\Student;

class ClassController extends Controller
{
    /**
     * Display a listing of the classes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Eager load both the professor and students relationships
        $classes = ClassList::with(['professor', 'students'])->paginate(10);

        return view('classes.index', compact('classes'));
    }
    /**
     * Show the form for creating a new class.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Fetch all professors and students to assign to the class
        $professors = Prof::all();
        $students = Student::all();

        return view('classes.create', compact('professors', 'students'));
    }

    /**
     * Store a newly created class in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|string|max:255',
            'sum' => 'required|integer|min:1',
            'prof_id' => 'nullable|exists:profs,id',
            'students' => 'nullable|array',
            'students.*' => 'exists:students,id',
        ]);

        // Check if the number of students exceeds the class limit
        $studentCount = count($request->students ?? []);
        $classLimit = $validated['sum'];

        if ($studentCount > $classLimit) {
            return redirect()->back()->withErrors(['students' => 'Number of students exceeds the class limit.'])->withInput();
        }

        // Create the new class
        $class = ClassList::create($validated);

        // Attach students if any
        if ($request->has('students')) {
            $class->students()->attach($request->students);
        }

        return redirect()->route('classes.index')->with('success', 'Class created successfully.');
    }
    /**
     * Display the specified class.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $class = ClassList::with('professor', 'students')->findOrFail($id);

        return view('classes.show', compact('class'));
    }
    /**
     * Show the form for editing the specified class.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Fetch the class by ID
        $class = ClassList::findOrFail($id);

        // Fetch all professors and students for the form options
        $professors = Prof::all();
        $students = Student::all();

        // Pass the class, professors, and students to the view
        return view('classes.edit', compact('class', 'professors', 'students'));
    }

    /**
     * Update the specified class in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|string|max:255',
            'sum' => 'required|integer|min:1',
            'prof_id' => 'nullable|exists:profs,id',
            'students' => 'nullable|array',
            'students.*' => 'exists:students,id',
        ]);

        // Find the class by ID
        $class = ClassList::findOrFail($id);

        // Check if the number of students exceeds the class limit
        $studentCount = count($request->students ?? []);
        $classLimit = $validated['sum'];

        if ($studentCount > $classLimit) {
            return redirect()->back()->withErrors(['students' => 'Number of students exceeds the class limit.'])->withInput();
        }

        // Update the class with validated data
        $class->update([
            'name' => $validated['name'],
            'class_id' => $validated['class_id'],
            'sum' => $validated['sum'],
            'prof_id' => $validated['prof_id'] ?? null, // Handle nullable field
        ]);

        // Sync students to the class (assuming many-to-many relationship)
        $class->students()->sync($validated['students'] ?? []);

        // Redirect to the class index or another page with a success message
        return redirect()->route('classes.index')->with('success', 'Class updated successfully.');
    }

    /**
     * Remove the specified class from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the class by its ID or fail
        $class = ClassList::findOrFail($id);

        // Detach the class from the professor if necessary
        if ($class->professor) {
            $class->professor()->dissociate();
        }

        // Detach all students associated with this class
        $class->students()->detach();

        // Delete the class
        $class->delete();

        // Redirect to the index page with a success message
        return redirect()->route('classes.index')->with('success', 'Class deleted successfully.');
    }
}
