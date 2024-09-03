<x-layout>
    <x-slot:title>
        Request Details
    </x-slot:title>

    <div class="px-4 sm:px-0">
        <h3 class="text-base font-semibold leading-7 text-gray-900">Request Details</h3>
        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Here you can view the details of the request. Please
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
        <a href="{{ route('professors.requestList') }}" class="text-sm font-semibold leading-6 text-gray-900">
            Back to Request List
        </a>

        <form action="{{ route('professors.denyRequest', $request->id) }}" method="POST">
            @csrf
            <button type="submit"
                class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                Deny
            </button>
        </form>

        <form action="{{ route('professors.grantRequest', $request->id) }}" method="POST">
            @csrf
            <button type="submit"
                class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                Grant
            </button>
        </form>
    </div>
</x-layout>
