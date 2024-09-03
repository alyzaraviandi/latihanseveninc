<x-layout>
    <x-slot:title>
        Edit Student: {{ $student->name }}
    </x-slot:title>

    <div class="px-4 sm:px-0">
        <h3 class="text-base font-semibold leading-7 text-gray-900">Student Information</h3>
        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Edit the student's details below.</p>
    </div>

    <form method="POST" action="{{ route('students.update', ['id' => $student->id]) }}">
        @csrf
        @method('PUT')

        <div class="mt-6 border-t border-gray-100">
            <dl>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Full name</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        <input type="text" name="name" value="{{ old('name', $student->name) }}"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Student Number</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        <input type="text" name="student_number"
                            value="{{ old('student_number', $student->student_number) }}" readonly
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Place of Birth</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        <input type="text" name="place_of_birth"
                            value="{{ old('place_of_birth', $student->place_of_birth) }}"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Date of Birth</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        <input type="date" name="date_of_birth"
                            value="{{ old('date_of_birth', $student->date_of_birth) }}"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Enrolled Classes</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        @foreach ($classes as $class)
                            @php
                                $currentCount = $class->currentStudentCount();
                                $isFull = $currentCount >= $class->sum; // Check if class is full
                                $isEnrolled = in_array(
                                    $class->id,
                                    old('classes', $student->classes->pluck('id')->toArray()),
                                );
                            @endphp
                            <div class="flex items-center gap-x-3">
                                <input type="checkbox" name="classes[]" value="{{ $class->id }}"
                                    id="class-{{ $class->id }}" {{ $isEnrolled ? 'checked' : '' }}
                                    {{ !$isEnrolled && $isFull ? 'disabled' : '' }} data-max="{{ $class->sum }}"
                                    data-current="{{ $currentCount }}">
                                <label for="class-{{ $class->id }}"
                                    class="text-sm font-medium leading-6 text-gray-900 {{ !$isEnrolled && $isFull ? 'text-gray-500' : '' }}">
                                    {{ $class->name }}
                                    @if ($class->professor)
                                        (Professor: {{ $class->professor->name }})
                                    @else
                                        (Professor: Not Assigned)
                                    @endif
                                    @if ($isFull)
                                        (Full)
                                    @else
                                        (Available)
                                    @endif
                                    (<span id="class-{{ $class->id }}_count">{{ $currentCount }}</span> /
                                    {{ $class->sum }})
                                </label>
                            </div>
                        @endforeach
                    </dd>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const checkboxes = document.querySelectorAll('input[name="classes[]"]');

                        checkboxes.forEach(checkbox => {
                            checkbox.addEventListener('change', function() {
                                const isChecked = this.checked;
                                const classId = this.id.replace('class-', '');
                                const countSpan = document.getElementById(`class-${classId}_count`);
                                const max = parseInt(this.getAttribute('data-max'));
                                let current = parseInt(this.getAttribute('data-current'));
                                const initialCount = parseInt(this.getAttribute('data-initial'));

                                // Update current count based on checkbox state
                                if (isChecked) {
                                    current += 1;
                                } else {
                                    current -= 1;
                                }
                                // Update the displayed count
                                countSpan.textContent = current;

                                // Update the current count in the data attribute
                                this.setAttribute('data-current', current);

                                // Update the disabled state of the checkbox
                                if (!isChecked && current >= max) {
                                    this.disabled = true;
                                } else {
                                    this.disabled = false;
                                }
                            });
                        });
                    });
                </script>

            </dl>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm font-semibold leading-6 text-gray-900">
                <a href="{{ route('students.show', ['id' => $student->id]) }}">Cancel</a>
            </button>
            <button type="submit"
                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Save
            </button>
        </div>
    </form>
</x-layout>
