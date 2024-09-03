<x-layout>
    <x-slot:title>
        Classes List
    </x-slot:title>

    <div class="mb-4 flex space-x-4">
        <x-button href="{{ route('classes.create') }}" class="bg-blue-600 hover:bg-blue-700">Create Classes</x-button>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Class Name</th>
                    <th scope="col" class="px-6 py-3">Class ID</th>
                    <th scope="col" class="px-6 py-3">Students</th>
                    <th scope="col" class="px-6 py-3">Professor</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classes as $class)
                    <tr>
                        <td class="px-6 py-4">{{ $class->id }}</td>
                        <td class="px-6 py-4">{{ $class->name }}</td>
                        <td class="px-6 py-4">{{ $class->class_id }}</td>
                        <td class="px-6 py-4">
                            {{ $class->currentStudentCount() }} / {{ $class->sum }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $class->professor->name ?? 'None' }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('classes.show', $class->id) }}"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4 bg-white shadow-md rounded-lg p-4 border border-gray-200"
            aria-label="Table navigation">
            <span
                class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto mr-4">
                Showing {{ $classes->firstItem() }} to {{ $classes->lastItem() }} of {{ $classes->total() }} results
            </span>
            <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                <!-- Pagination links -->
                @if ($classes->hasPages())
                    <li>
                        <a href="{{ $classes->previousPageUrl() }}"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-gray-500 bg-white hover:bg-gray-100">Previous</a>
                    </li>
                    @for ($i = 1; $i <= $classes->lastPage(); $i++)
                        <li>
                            <a href="{{ $classes->url($i) }}"
                                class="px-3 py-2 border border-gray-300 rounded-lg {{ $i == $classes->currentPage() ? 'bg-blue-500 text-white' : 'bg-white text-gray-500 hover:bg-gray-100' }}">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor
                    <li>
                        <a href="{{ $classes->nextPageUrl() }}"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-gray-500 bg-white hover:bg-gray-100">Next</a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</x-layout>
