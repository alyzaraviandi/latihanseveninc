<x-layout>
    <x-slot:title>
        Students
    </x-slot:title>

    @if (Auth::user()->role === 'head')
        <div class="mb-4 flex space-x-4">
            <x-button href="{{ route('students.create') }}" class="bg-blue-600 hover:bg-blue-700">Create
                Student</x-button>
        </div>
    @endif


    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Student Number</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Classes</th>
                    <th scope="col" class="px-6 py-3">Place of Birth</th>
                    <th scope="col" class="px-6 py-3">Date of Birth</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">{{ $student->id }}</td>
                        <td class="px-6 py-4">{{ $student->student_number }}</td>
                        <td class="px-6 py-4">{{ $student->name }}</td>
                        <td class="px-6 py-4">
                            @foreach ($student->classes as $class)
                                {{ $class->name }}<br>
                            @endforeach
                        </td>
                        <td class="px-6 py-4">{{ $student->place_of_birth }}</td>
                        <td class="px-6 py-4">{{ $student->date_of_birth }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('students.show', $student->id) }}"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4 bg-white shadow-md rounded-lg p-4 border border-gray-200"
            aria-label="Table navigation">
            <span
                class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto mr-4">
                Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} results
            </span>
            <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                <!-- Pagination links -->
                @if ($students->hasPages())
                    <li>
                        <a href="{{ $students->previousPageUrl() }}"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-gray-500 bg-white hover:bg-gray-100">Previous</a>
                    </li>
                    @for ($i = 1; $i <= $students->lastPage(); $i++)
                        <li>
                            <a href="{{ $students->url($i) }}"
                                class="px-3 py-2 border border-gray-300 rounded-lg {{ $i == $students->currentPage() ? 'bg-blue-500 text-white' : 'bg-white text-gray-500 hover:bg-gray-100' }}">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor
                    <li>
                        <a href="{{ $students->nextPageUrl() }}"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-gray-500 bg-white hover:bg-gray-100">Next</a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</x-layout>
