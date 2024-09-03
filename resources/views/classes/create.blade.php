<x-layout>
    <x-slot:title>
        Create Class
    </x-slot:title>

    <form method="POST" action="{{ route('classes.store') }}" id="class-form">
        @csrf

        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Class Information</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Enter the class details below.</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <!-- Class Name -->
                    <div class="sm:col-span-3">
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Class
                            Name</label>
                        <div class="mt-2">
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Class ID -->
                    <div class="sm:col-span-3">
                        <label for="class_id" class="block text-sm font-medium leading-6 text-gray-900">Class ID</label>
                        <div class="mt-2">
                            <input type="text" name="class_id" id="class_id" value="{{ old('class_id') }}"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            @error('class_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Class Limit (sum) -->
                    <div class="sm:col-span-3">
                        <label for="sum" class="block text-sm font-medium leading-6 text-gray-900">Class
                            Limit</label>
                        <div class="mt-2">
                            <input type="number" name="sum" id="sum" value="{{ old('sum') }}"
                                min="1"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            @error('sum')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Assign Professor -->
                    <div class="sm:col-span-3">
                        <label for="prof_id" class="block text-sm font-medium leading-6 text-gray-900">Assign
                            Professor</label>
                        <div class="mt-2">
                            <select id="prof_id" name="prof_id"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option value="">None</option>
                                @foreach ($professors as $professor)
                                    <option value="{{ $professor->id }}">{{ $professor->name }}</option>
                                @endforeach
                            </select>
                            @error('prof_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Assign Students -->
                    <div class="sm:col-span-6">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Assign Students</label>
                        <div class="mt-2 space-y-2">
                            @if ($students->isEmpty())
                                <p class="text-xs mt-1">No students available for assignment.</p>
                            @else
                                @foreach ($students as $student)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="students[]" value="{{ $student->id }}"
                                            id="student_{{ $student->id }}"
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-600 border-gray-300 rounded">
                                        <label for="student_{{ $student->id }}"
                                            class="ml-2 text-sm font-medium text-gray-900">{{ $student->name }}</label>
                                    </div>
                                @endforeach
                            @endif
                            @error('students')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <!-- Cancel Button -->
            <a href="{{ route('classes.index') }}" class="text-sm font-semibold leading-6 text-gray-900">
                Cancel
            </a>

            <!-- Save Button -->
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
        });
    </script>
</x-layout>
