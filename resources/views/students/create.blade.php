<x-layout>
    <x-slot:title>
        Create Students
    </x-slot:title>

    <form method="POST" action="{{ route('students.store') }}">
        @csrf
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Student Information</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Enter the student's details below.</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <!-- Name -->
                    <div class="sm:col-span-3">
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                        <div class="mt-2">
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="sm:col-span-3">
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                        <div class="mt-2">
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="sm:col-span-3">
                        <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                        <div class="mt-2">
                            <input type="text" name="username" id="username" value="{{ old('username') }}"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            @error('username')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="sm:col-span-3">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        <div class="mt-2">
                            <input type="password" name="password" id="password"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="password_confirmation"
                            class="block text-sm font-medium leading-6 text-gray-900">Confirm Password</label>
                        <div class="mt-2">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            @error('password_confirmation')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Place of Birth -->
                    <div class="sm:col-span-3">
                        <label for="place_of_birth" class="block text-sm font-medium leading-6 text-gray-900">Place of
                            Birth</label>
                        <div class="mt-2">
                            <input type="text" name="place_of_birth" id="place_of_birth"
                                value="{{ old('place_of_birth') }}"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            @error('place_of_birth')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Date of Birth -->
                    <div class="sm:col-span-3">
                        <label for="date_of_birth" class="block text-sm font-medium leading-6 text-gray-900">Date of
                            Birth</label>
                        <div class="mt-2">
                            <input type="date" name="date_of_birth" id="date_of_birth"
                                value="{{ old('date_of_birth') }}"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            @error('date_of_birth')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Student Number -->
                    <div class="sm:col-span-3">
                        <label for="student_number" class="block text-sm font-medium leading-6 text-gray-900">Student
                            Number</label>
                        <div class="mt-2">
                            <input type="text" name="student_number" id="student_number"
                                value="{{ old('student_number') }}"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            @error('student_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Classes</label>
                        <div class="mt-2 space-y-2">
                            @foreach ($classes as $class)
                                @php
                                    $currentCount = $class->currentStudentCount();
                                    $isFull = $currentCount >= $class->sum; // Check if class is full
                                @endphp
                                <div class="flex items-center">
                                    <input type="checkbox" name="classes[]" value="{{ $class->id }}"
                                        id="class_{{ $class->id }}"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-600 border-gray-300 rounded"
                                        {{ $isFull ? 'disabled' : '' }} data-max="{{ $class->sum }}"
                                        data-current="{{ $currentCount }}">
                                    <label for="class_{{ $class->id }}"
                                        class="ml-2 text-sm font-medium text-gray-900 {{ $isFull ? 'text-gray-500' : '' }}">
                                        {{ $class->name }}
                                        @if ($isFull)
                                            (Full)
                                        @else
                                            (Available)
                                        @endif
                                        (<span id="class_{{ $class->id }}_count">{{ $currentCount }}</span> /
                                        {{ $class->sum }})
                                    </label>
                                </div>
                            @endforeach
                            @error('classes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const checkboxes = document.querySelectorAll('input[name="classes[]"]');

                            checkboxes.forEach(checkbox => {
                                checkbox.addEventListener('change', function() {
                                    const isChecked = this.checked;
                                    const classId = this.id.replace('class_', '');
                                    const countSpan = document.getElementById(`class_${classId}_count`);
                                    const max = parseInt(this.getAttribute('data-max'));
                                    let current = parseInt(this.getAttribute('data-current'));
                                    const initialCount = parseInt(this.getAttribute('data-initial'));

                                    if (isChecked) {
                                        current += 1;
                                    } else {
                                        current -= 1;
                                    }

                                    // Update the displayed count
                                    countSpan.textContent = current;

                                    this.setAttribute('data-current', current);

                                    if (!isChecked && current >= max) {
                                        this.disabled = true;
                                    } else {
                                        this.disabled = false;
                                    }
                                });
                            });
                        });
                    </script>

                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <!-- Cancel Button -->
            <a href="{{ route('students.index') }}" class="text-sm font-semibold leading-6 text-gray-900">
                Cancel
            </a>

            <!-- Save Button -->
            <button type="submit"
                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Save
            </button>
        </div>
    </form>

</x-layout>
