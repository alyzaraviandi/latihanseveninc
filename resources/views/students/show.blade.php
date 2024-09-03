<x-layout>
    <x-slot:title>
        Student Details
    </x-slot:title>

    <div class="mb-4 flex space-x-4">
        <!-- Edit Button -->
        <x-button href="{{ route('students.edit', ['id' => $student->id]) }}" class="bg-blue-600 hover:bg-blue-700">
            Edit Student
        </x-button>


        @if (Auth::user()->role === 'head')
            <form action="{{ route('students.destroy', ['id' => $student->id]) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this student?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white font-medium rounded-full text-sm px-5 py-2.5 text-center">
                    Delete Student
                </button>
            </form>
        @endif

    </div>

    <div>
        <div class="px-4 sm:px-0">
            <h3 class="text-base font-semibold leading-7 text-gray-900">Student Information</h3>
            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Personal details and enrolled classes.</p>
        </div>
        <div class="mt-6 border-t border-gray-100">
            <dl>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <!-- Add bottom border to each row -->
                    <dt class="text-sm font-medium leading-6 text-gray-900">Full name</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $student->name }}</dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Student Number</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ $student->student_number }}</dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Place of Birth</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ $student->place_of_birth }}</dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Date of Birth</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $student->date_of_birth }}
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Enrolled Classes</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        @if ($student->classes->isEmpty())
                            <p>No classes enrolled</p>
                        @else
                            <ul>
                                @foreach ($student->classes as $class)
                                    <li>
                                        {{ $class->name }} (Professor: {{ $class->professor->name }})
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </dd>
                </div>

            </dl>
        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="{{ route('students.index') }}" class="text-sm font-semibold leading-6 text-gray-900">
                Back to Students List
            </a>
        </div>
    </div>
</x-layout>
