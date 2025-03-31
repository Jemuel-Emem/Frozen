<div>
    <div class="container mx-auto px-5 bg-white">
        <div class="flex lg:flex-row flex-col-reverse shadow-lg">

            <div class="w-full lg:w-3/5 min-h-screen shadow-lg">

                <div class="flex flex-row justify-between items-center px-5 mt-5">
                    <div class="text-gray-800">
                        <div class="font-bold text-xl">Kai's Frozen Store</div>
                        <span class="text-xs">Location ID#SIMON123</span>
                    </div>
                </div>

                <div class="mt-5 flex flex-row px-5">
                    <span wire:click="setCategory('All items')" class="cursor-pointer px-5 py-1 {{ $category === 'All items' ? 'bg-yellow-500 text-white' : '' }} rounded-2xl text-sm font-semibold mr-4">All items</span>
                    <span wire:click="setCategory('Pork')" class="cursor-pointer px-5 py-1 {{ $category === 'Pork' ? 'bg-yellow-500 text-white' : '' }} rounded-2xl text-sm font-semibold mr-4">Pork</span>
                    <span wire:click="setCategory('Chicken')" class="cursor-pointer px-5 py-1 {{ $category === 'Chicken' ? 'bg-yellow-500 text-white' : '' }} rounded-2xl text-sm font-semibold mr-4">Chicken</span>
                    <span wire:click="setCategory('Beef')" class="cursor-pointer px-5 py-1 {{ $category === 'Beef' ? 'bg-yellow-500 text-white' : '' }} rounded-2xl text-sm font-semibold mr-4">Beef</span>
                </div>

                <div class="grid grid-cols-3 gap-4 px-5 mt-5 overflow-y-auto ">
                    @foreach($products as $product)
                    <div wire:click="addToOrder({{ $product->id }})" class="px-3 py-3 flex flex-col border border-gray-200 rounded-md h-32 justify-between cursor-pointer">
                        <div>
                            <div class="font-bold text-gray-800">{{ $product->productname }}</div>
                        </div>
                        <div class="flex flex-row justify-between items-center">
                            <span class="self-end font-bold text-lg text-yellow-500">php{{ number_format($product->price, 2) }}</span>
                            <img src="{{ asset('storage/' . $product->photo) }}" class="h-14 w-14 object-cover rounded-md" alt="">
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>

            <div class="w-full lg:w-2/5">

                <div class="flex flex-row items-center justify-between px-5 mt-5">
                    <div class="font-bold text-xl">Current Order</div>
                    <div class="font-semibold">
                        <span wire:click="clearOrder()" class="px-4 py-2 rounded-md bg-red-100 text-red-500 cursor-pointer">Clear All</span>
                    </div>
                </div>

                <div class="px-5 py-4 mt-5 overflow-y-auto h-64">
                    @foreach($currentOrder as $index => $orderItem)
                    <div class="flex flex-row justify-between items-center mb-4">
                        <div class="flex flex-row items-center w-2/5">
                            <img src="{{ asset('storage/' . $orderItem['photo']) }}" class="w-10 h-10 object-cover rounded-md" alt="">
                            <span class="ml-4 font-semibold text-sm">{{ $orderItem['productname'] }}</span>
                        </div>
                        <div class="w-32 flex justify-between">
                            <span wire:click="decrementQuantity({{ $index }})" class="px-3 py-1 rounded-md bg-gray-300 cursor-pointer">-</span>
                            <span class="font-semibold mx-4">{{ $orderItem['quantity'] }}</span>
                            <span wire:click="incrementQuantity({{ $index }})" class="px-3 py-1 rounded-md bg-gray-300 cursor-pointer">+</span>
                        </div>
                        <div class="font-semibold text-lg w-16 text-center">
                            php{{ number_format($orderItem['price'] * $orderItem['quantity'], 2) }}
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- end order list -->
                <!-- totalItems -->
                <div class="px-5 mt-5">
                    <div class="py-4 rounded-md shadow-lg">
                        <div class="px-4 flex justify-between">
                            <span class="font-semibold text-sm">Subtotal</span>
                            <span class="font-bold">Php{{ number_format($subtotal, 2) }}</span>
                        </div>
                        {{-- <div class="px-4 flex justify-between">
                            <span class="font-semibold text-sm">Discount</span>
                            <span class="font-bold">- $5.00</span>
                        </div> --}}
                        {{-- <div class="px-4 flex justify-between">
                            <span class="font-semibold text-sm">Sales Tax</span>
                            <span class="font-bold">$2.25</span>
                        </div> --}}
                        <div class="border-t-2 mt-3 py-2 px-4 flex items-center justify-between">
                            <span class="font-semibold text-2xl">Total</span>
                            <span class="font-bold text-2xl">Php{{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-row justify-center items-center">
                    <div class="flex flex-col">
                        <span class="uppercase text-xs font-semibold mt-2">CASH</span>
                        <input wire:model="cashAmount" type="text" class="border border-gray-300 px-3 py-2 mt-1 rounded-md focus:outline-none focus:ring focus:ring-yellow-500 focus:border-yellow-500">
                    </div>

                </div>


                <div class="px-5 mt-5 text-center">

            <button wire:click="pay" class="w-64 py-4  shadow-lg text-center   font-semibold cursor-pointer px-4 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">Pay</button>

                </div>
                <!-- end button pay -->
            </div>
            <!-- end right section -->
        </div>
    </div>

    {{-- <x-modal wire:model.defer="reciept_modal">
        <x-card title="Reciept" id="receipt-content">
            <div class="space-y-3">
                @foreach($currentOrder as $orderItem)
                <div class="flex justify-between mb-2">
                    <span>{{ $orderItem['productname'] }}</span>
                    <span>Php{{ number_format($orderItem['price'] * $orderItem['quantity'], 2) }}</span>
                </div>
                @endforeach

                <div class="flex justify-between mt-4">
                    <span>Subtotal:</span>
                    <span>Php{{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between mt-2">
                    <span>Total:</span>
                    <span>Php{{ number_format($total, 2) }}</span>
                </div>

                <div class="flex justify-between mt-4">
                    <span>Cash:</span>
                    <span>Php{{ number_format($cashAmount, 2) }}</span>
                </div>
                <div class="flex justify-between mt-2">
                    <span>Change:</span>
                    <span>Php{{ number_format($change, 2) }}</span>
            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button label="Pay Now" wire:click="paynow" onclick="printReceipt()" spinner="addrider" green />
                </div>
            </x-slot>
        </x-card>
    </x-modal> --}}

    <x-modal wire:model.defer="reciept_modal">
        <x-card id="receipt-content">
            <div class="text-center border-b pb-3">
                <h2 class="text-lg font-bold">Kai's Frozen Store</h2>
                <p class="text-xs text-gray-500">Location ID: #SIMON123</p>
                <p class="text-xs text-gray-500">Thank you for your purchase!</p>
            </div>

            <div class="space-y-3 mt-3 text-sm">
                <div class="border-b pb-2 flex justify-between font-semibold">
                    <span>Item</span>
                    <span>Qty</span>
                    <span>Price</span>
                    <span>Total</span>
                </div>

                @foreach($currentOrder as $orderItem)
                <div class="flex justify-between items-center text-gray-700 border-b py-2">
                    <span>{{ $orderItem['productname'] }}</span>
                    <span class="text-center">{{ $orderItem['quantity'] }}</span>
                    <span>Php{{ number_format($orderItem['price'], 2) }}</span>
                    <span class="font-semibold">Php{{ number_format($orderItem['price'] * $orderItem['quantity'], 2) }}</span>
                </div>
                @endforeach

                <div class="border-t mt-3 pt-3">
                    <div>
                        <p>Subtotal: ₱{{ number_format($subtotal, 2) }}</p>
                        <p>VAT ({{ $vatRate }}%): ₱{{ number_format($vatAmount, 2) }}</p>
                        <p><strong>Total: ₱{{ number_format($total, 2) }}</strong></p>

                    </div>

                    <div class="flex justify-between text-gray-800">
                        <span>Cash:</span>
                        <span class="font-semibold">Php{{ number_format($cashAmount, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-800">
                        <span>Change:</span>
                        <span class="font-semibold">Php{{ number_format($change, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="text-center text-xs text-gray-500 mt-3">
                <p>*** Thank you for shopping with us! ***</p>
                <p>For inquiries, call: (123) 456-7890</p>
            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Close" x-on:click="close" />
                    <x-button label="Pay Now" wire:click="paynow" wire:loading.attr="disabled" x-on:click="setTimeout(printReceipt, 500)" spinner="addrider" green />


                </div>
            </x-slot>
        </x-card>
    </x-modal>


    <script>
        function printReceipt() {
            let printContent = document.getElementById('receipt-content').innerHTML;
            let originalContent = document.body.innerHTML;

            document.body.innerHTML = `
                <div style="max-width: 300px; margin: auto; font-family: Arial, sans-serif;">
                    ${printContent}
                </div>`;
            window.print();
            document.body.innerHTML = originalContent;
            window.location.reload();
        }
    </script>


</div>
