<x-layout>
    <x-slot:title>
        Request Details
    </x-slot:title>

    <div class="px-4 sm:px-0">
        <h3 class="text-base font-semibold leading-7 text-gray-900">Request Details</h3>
        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Here you can view the details of your request. Please
            review the information below.</p>
    </div>

    <div class="mt-6 border-t border-gray-100">
        <dl>
            <!-- Class Information -->
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Class</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                    {{ $request->class->name ?? 'N/A' }} - Professor:
                    {{ $request->class->professor->name ?? 'N/A' }}
                </dd>
            </div>

            <!-- Status Information -->
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Status</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                    {{ ucfirst($request->status) }}
                </dd>
            </div>

            <!-- Created At -->
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Created At</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                    {{ $request->created_at->format('Y-m-d H:i:s') }}
                </dd>
            </div>

            <!-- Requested Changes -->
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b border-gray-300 last:border-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Requested Changes</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                    {{ $request->info }}
                </dd>
            </div>
        </dl>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
        <a href="{{ route('students.requestList') }}" class="text-sm font-semibold leading-6 text-gray-900">
            Back to Request List
        </a>

        @if ($request->status == 'denied')
            <form action="{{ route('students.deleteRequest', $request->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-800">
                    Delete
                </button>
            </form>
        @elseif ($request->status == 'granted')
            @if ($request->student->edit)
                <a href="{{ route('students.edit', ['id' => $request->student_id]) }}"
                    class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    Edit
                </a>
            @endif
        @endif
    </div>
</x-layout>
