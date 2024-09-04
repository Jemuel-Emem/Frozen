<div class="overflow-x-auto mt-4">
    @if ($assignedOrders->isEmpty())
        <p class="text-white text-center text-2xl">No assigned orders found for this rider <i class="ri-emotion-sad-fill text-yellow-500 text-4xl"></i></p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($assignedOrders as $assignedOrder)
                <x-card class="dark:border-gray-700 border border-gray-200 shadow-md rounded-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white p-4">
                        <h3 class="font-semibold text-lg">Order #{{ $assignedOrder->id }}</h3>
                    </div>

                    <div class="p-4 space-y-3 text-gray-700 dark:text-gray-300">
                        <p><span class="font-semibold">Address:</span> {{ $assignedOrder->address }}</p>
                        <p><span class="font-semibold">Phone number:</span> {{ $assignedOrder->phonenumber }}</p>
                        <div>
                            @php
                            $products = json_decode($assignedOrder->productlist);
                            $productNames = [];
                            foreach ($products as $product) {
                                $productNames[] = $product->productname;
                            }
                            echo implode(', ', $productNames);
                        @endphp
                        </div>

                        <p><span class="font-semibold">Total Order:</span> {{ $assignedOrder->totalorder }} Php</p>
                    </div>

                    <footer class="p-4 bg-gray-100 dark:bg-gray-800">
                        <button  wire:click="confirmOrder({{ $assignedOrder->id }})" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg w-full flex items-center justify-center space-x-2">
                            <i class="ri-check-line text-xl"></i>
                            <span>Confirm Order</span>
                        </button>
                    </footer>
                </x-card>
            @endforeach
        </div>
    @endif
</div>
