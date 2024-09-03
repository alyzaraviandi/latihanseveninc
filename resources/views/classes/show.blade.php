<x-layout>
    <x-slot:title>
        Class Details
    </x-slot:title>

    <div class="mb-4 flex space-x-4">
        <!-- Edit Button -->
        <x-button href="{{ route('classes.edit', ['id' => $class->id]) }}" class="bg-blue-600 hover:bg-blue-700">
            Edit Class
        </x-button>

        <!-- Delete Button -->
        <form action="#" method="POST" onsubmit="return confirm('Are you sure you want to delete this class?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white font-medium rounded-full text-sm px-5 py-2.5 text-center">
                Delete Class
            </button>
        </form>
    </div>

    <div>
        <div class="px-4 sm:px-0">
            <h3 class="text-base font-semibold leading-7 text-gray-900">Class Information</h3>
            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Details about the class and the professor.</p>
        </div>
        <div class="mt-6 border-t border-gray-100">
            <dl>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <!-- Add bottom border to each row -->
                    <dt class="text-sm font-medium leading-6 text-gray-900">Class Name</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $class->name }}</dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Class ID</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $class->class_id }}</dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Total Students</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ $class->students->count() }}</dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Professor</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        @if ($class->professor)
                            {{ $class->professor->name }}
                        @else
                            <p>No professor assigned</p>
                        @endif
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Students</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        @if ($class->students->isEmpty())
                            <p>No students enrolled</p>
                        @else
                            <ul>
                                @foreach ($class->students as $student)
                                    <li>{{ $student->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="{{ route('classes.index') }}" class="text-sm font-semibold leading-6 text-gray-900">
                Back to Class List
            </a>
        </div>
    </div>
</x-layout>
