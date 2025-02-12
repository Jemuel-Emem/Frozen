<div>
    @if(session()->has('message'))
    <div class="text-green-500 mt-4">{{ session('message') }}</div>
@endif


    @foreach($orders as $order)
    <div class="mt-4">
        <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200">
            <div class="grid md:grid-cols-4 grid-cols-1 gap-4">
                <p class="text-gray-700">
                    <strong class="text-gray-900">Order List:</strong> {{ $order->productlist }}
                </p>
                <p class="text-gray-700">
                    <strong class="text-gray-900">Total Order:</strong> ₱{{ number_format($order->totalorder, 2) }}
                </p>
                <p class="text-gray-700">
                    <strong class="text-gray-900">Status:</strong>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        {{ $order->status == 'Completed' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                        {{ $order->status }}
                    </span>
                </p>
            </div>

            <!-- Add Feedback Button -->
            <div class="mt-6 text-end">
                <button wire:click="openFeedbackModal({{ $order->id }})"
                    class="px-4 py-2 rounded-lg font-semibold transition duration-300
                    {{ $order->feedback ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-500 hover:bg-blue-600 text-white' }}"
                    {{ $order->feedback ? 'disabled' : '' }}>
                {{ $order->feedback ? 'Already Submitted' : 'Add Feedback' }}
            </button>

            </div>
        </div>
    </div>
@endforeach


    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                <h2 class="text-lg font-bold mb-4">Submit Feedback</h2>

                <textarea wire:model.defer="feedback" class="w-full border rounded-md p-2" rows="4"></textarea>

                <div class="flex justify-end mt-4">
                    <button wire:click="resetModal" class="bg-gray-400 text-white px-4 py-2 rounded-md mr-2">Cancel</button>
                    <button wire:click="submitFeedback" class="bg-blue-500 text-white px-4 py-2 rounded-md">Submit</button>
                </div>
            </div>
        </div>
    @endif


</div>
