<div class="p-12 h-screen">
    <div class="flex justify-end mb-4">
        <button wire:click="calculateTotalPrice">
            <span class="text-right underline text-white">Order Summary</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($product as $cot)
            <x-card title="{{ $cot->productname }}" class="text-blue-500">
                <div>
                    <img src="{{ asset(Storage::url($cot->photo)) }}" alt="Valid ID" class="w-full h-32 object-cover rounded">
                    <x-inputs.number wire:model="quantities.{{ $cot->id }}" label="Item Quantity" />
                    {{-- <a href="{{ route('terms') }}" class="text-green-500 underline">Terms and Condition</a> --}}
                </div>

                <x-slot name="footer">
                    <div class="flex justify-between items-center">
                        <label for="" class="text-blue-700">{{ $cot->price }} Php</label>
                        <div>
                            <div x-data="{ title: 'Sure Delete?' }">
                                <x-button label="Delete" class="bg-red-500 text-white"
                                    x-on:confirm="{
                                        title,
                                        icon: 'warning',
                                        method: 'delete',
                                        params: {{ $cot->id }}
                                    }"
                                />
                            </div>
                        </div>
                    </div>
                    <x-checkbox id="checkbox_{{ $cot->id }}" wire:model="selectedProducts.{{ $cot->id }}" />
                </x-slot>
            </x-card>
        @endforeach
    </div>

    <x-modal wire:model.defer="open_modal">
        <x-card  class="relative">
            @if(count($selectedProductList) > 0)
                <div class="mb-4">
                    <h2 class="text-xl font-bold mb-2 text-blue-500">Order List:</h2>
                    <ul class="space-y-3">
                        @foreach($selectedProductList as $selectedProduct)
                            <li class="flex items-center space-x-4">
                                <img class="w-20 h-20 object-cover rounded" src="{{ asset('storage/' . $selectedProduct->photo) }}" alt="{{ $selectedProduct->productname }}">
                                <div class="flex-1">
                                    <p class="font-semibold">{{ $selectedProduct->productname }}</p>
                                    <p class="text-blue-700">Php{{ $selectedProduct->price }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <p class="text-gray-500 text-center">No products selected.</p>
            @endif

            <div class="space-y-3">
                <p class="md:text-2xl text-xl text-blue-500 font-semibold">Total Price: {{ $totalPrice }} Php</p>
            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4 mt-4">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button class="bg-blue-500 hover:bg-blue-700 text-white" label="Place Order" wire:click="ordernow" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
