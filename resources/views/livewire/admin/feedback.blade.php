<div class="p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-xl font-bold mb-4">User Feedbacks</h2>

    @if($feedbacks->isEmpty())
        <p class="text-gray-500">No feedback available.</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr class="text-left">
                        {{-- <th class="border border-gray-300 px-4 py-2">#</th> --}}
                        <th class="border border-gray-300 px-4 py-2">Name</th>
                        <th class="border border-gray-300 px-4 py-2">Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($feedbacks as $index => $feedback)
                        <tr class="border-b">
                           {{-- <td class="border border-gray-300 px-4 py-2">{{ $feedbacks->firstItem() + $index }}</td> --}}
                            <td class="border border-gray-300 px-4 py-2">{{ $feedback->name }}</td>
                            <td class="border border-gray-300 px-4 py-2 italic">"{{ $feedback->feedback }}"</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $feedbacks->links() }}
        </div>
    @endif
</div>
