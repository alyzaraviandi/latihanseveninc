<x-layout>
    <x-slot:title>
        Request List
    </x-slot:title>

    <div class="mb-4 flex space-x-4">
        <x-button href="{{ route('students.requestEditForm', ['id' => $student->id]) }}"
            class="bg-blue-600 hover:bg-blue-700">
            Request Edit
        </x-button>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div
                class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white">
                <h2 class="text-lg font-semibold text-gray-900">Your Requests</h2>
            </div>
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Class
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Info
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Created At
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requests as $request)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">
                                {{ $request->class->name ?? 'N/A' }} - Professor:
                                {{ $request->class->professor->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $request->info }}
                            </td>
                            <td class="px-6 py-4">
                                {{ ucfirst($request->status) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $request->created_at->format('Y-m-d H:i:s') }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('students.requestDetails', $request->id) }}"
                                    class="font-medium text-blue-600 hover:underline">View Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center">
                                No requests found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
