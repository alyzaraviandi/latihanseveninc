<x-layout>
    <x-slot:title>
        Submit Request for Data Change
    </x-slot:title>

    <div class="px-4 sm:px-0">
        <h3 class="text-base font-semibold leading-7 text-gray-900">Request for Data Change</h3>
        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">You can request changes to your data below. Please
            specify the details and the class this request relates to.</p>
    </div>

    <form method="POST" action="{{ route('students.storeRequest', ['id' => $student->id]) }}">
        @csrf
        <div class="mt-6 border-t border-gray-100">
            <dl>
                <!-- Uneditable Student Data -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Full name</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ $student->name }}
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Student Number</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ $student->student_number }}
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Place of Birth</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ $student->place_of_birth }}
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Date of Birth</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ $student->date_of_birth }}
                    </dd>
                </div>

                <!-- Class Dropdown -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Select Class</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        <select name="class_id" required
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option value="" disabled selected>Select a class</option>
                            @foreach ($student->classes as $class)
                                <option value="{{ $class->id }}">
                                    {{ $class->name }} - Professor:
                                    {{ $class->professor ? $class->professor->name : 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </dd>
                </div>

                <!-- Info Textbox -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Requested Changes</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        <textarea name="info" rows="5" required
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            placeholder="Please describe the changes you want to request...">{{ old('info') }}</textarea>
                    </dd>
                </div>
            </dl>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm font-semibold leading-6 text-gray-900">
                <a href="{{ route('students.profile') }}">Cancel</a>
            </button>
            <button type="submit"
                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Submit Request
            </button>
        </div>
    </form>
</x-layout>
