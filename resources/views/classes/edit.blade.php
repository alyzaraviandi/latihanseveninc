<x-layout>
    <x-slot:title>
        Edit Class: {{ $class->name }}
    </x-slot:title>

    <div class="px-4 sm:px-0">
        <h3 class="text-base font-semibold leading-7 text-gray-900">Class Information</h3>
        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Edit the class details below.</p>
    </div>

    <form method="POST" action="{{ route('classes.update', ['id' => $class->id]) }}" id="class-form">
        @csrf
        @method('PUT')

        <div class="mt-6 border-t border-gray-100">
            <dl>
                <!-- Class Name -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Class Name</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        <input type="text" name="name" value="{{ old('name', $class->name) }}"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </dd>
                </div>

                <!-- Class ID -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Class ID</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        <input type="text" name="class_id" value="{{ old('class_id', $class->class_id) }}"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400">
                        @error('class_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </dd>
                </div>

                <!-- Class Limit (sum) -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Class Limit</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        <input type="number" name="sum" id="sum" value="{{ old('sum', $class->sum) }}"
                            min="1"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        @error('sum')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </dd>
                </div>

                <!-- Assign Professor -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Assign Professor</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        <select id="prof_id" name="prof_id"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option value="">None</option>
                            @foreach ($professors as $professor)
                                <option value="{{ $professor->id }}"
                                    {{ $class->prof_id == $professor->id ? 'selected' : '' }}>
                                    {{ $professor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('prof_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </dd>
                </div>

                <!-- Assign Students -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Assign Students</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        @if ($students->isEmpty())
                            <p class="text-xs mt-1">No students available for assignment.</p>
                        @else
                            <div class="mt-2 space-y-2">
                                @foreach ($students as $student)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="students[]" value="{{ $student->id }}"
                                            id="student_{{ $student->id }}"
                                            {{ $class->students->contains($student->id) ? 'checked' : '' }}
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-600 border-gray-300 rounded">
                                        <label for="student_{{ $student->id }}"
                                            class="ml-2 text-sm font-medium text-gray-900">{{ $student->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @error('students')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </dd>
                </div>
            </dl>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="{{ route('classes.show', ['id' => $class->id]) }}"
                class="text-sm font-semibold leading-6 text-gray-900">
                Cancel
            </a>
            <button type="submit"
                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Save
            </button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sumInput = document.getElementById('sum');
            const studentCheckboxes = document.querySelectorAll('input[name="students[]"]');
            const form = document.getElementById('class-form');
            const saveButton = form.querySelector('button[type="submit"]');

            function updateStudentCount() {
                const limit = parseInt(sumInput.value) || 0;
                const selectedCount = Array.from(studentCheckboxes).filter(cb => cb.checked).length;

                if (selectedCount > limit) {
                    saveButton.disabled = true;
                    saveButton.innerText = `Limit exceeded (${selectedCount}/${limit})`;
                } else {
                    saveButton.disabled = false;
                    saveButton.innerText = 'Save';
                }
            }

            sumInput.addEventListener('input', updateStudentCount);
            studentCheckboxes.forEach(cb => cb.addEventListener('change', updateStudentCount));

            // Initial check to set the correct button state on page load
            updateStudentCount();
        });
    </script>
</x-layout>
