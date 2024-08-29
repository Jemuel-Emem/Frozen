<div>
    <div class="p-2 flex gap-4">
        <x-input placeholder="Search Product" class="w-80" wire:model="search"></x-input>
        <x-button class="bg-orange-400 hover:bg-orange-500 text-white w-60" wire:click="find">Search</x-button>
    </div>

    <div>
        <h2 class="text-start text-2xl font-bold text-white uppercase">Promo Products</h2>
        <div class="p-8 rounded grid grid-cols-3 gap-3">
            @forelse ($productsWithPromo as $product)
            <x-card>
                <div class="flex justify-center flex-col">
                    <div class="">
                        <img src="{{ asset('storage/' . $product->photo) }}" alt="Product Photo" class="w-full h-32 object-cover">
                    </div>
                    <div class="text-center flex">
                        <div>
                            <span class="text-xl">Product name:</span>
                        </div>
                       <span class="text-xl"> {{ $product->productname }}</span>
                    </div>
                    <div class="text-xl">
                        <span class="font-bold">Price:</span>
                        {{ $product->price }}
                    </div>
                </div>
                <footer class="text-center">
                    <x-button class="bg-cyan-600 text-white w-full" wire:click="addToCart({{ $product->id }})">Add To Cart</x-button>
                </footer>
            </x-card>
            @empty
            <div class="col-span-3 text-center text-white">
                No promo products found.
            </div>
            @endforelse
        </div>
    </div>

    <div>
        <h2 class="text-star uppercase text-2xl font-bold text-white">Regular Products</h2>
        <div class="p-8 rounded grid grid-cols-3 gap-3">
            @forelse ($productsWithoutPromo as $product)
            <x-card>
                <div class="flex justify-center flex-col">
                    <div class="">
                        <img src="{{ asset('storage/' . $product->photo) }}" alt="Product Photo" class="w-full h-32 object-cover">
                    </div>
                    <div class="text-center flex">
                        <div>
                            <span class="text-xl">Product name:</span>
                        </div>
                       <span class="text-xl"> {{ $product->productname }}</span>
                    </div>
                    <div class="text-xl">
                        <span class="font-bold">Price:</span>
                        {{ $product->price }}
                    </div>
                </div>
                <footer class="text-center">
                    <x-button class="bg-cyan-600 text-white w-full" wire:click="addToCart({{ $product->id }})">Add To Cart</x-button>
                </footer>
            </x-card>
            @empty
            <div class="col-span-3 text-center">
                No products found.
            </div>
            @endforelse
        </div>
    </div>

    <div class="p-4">
        {{ $productsWithoutPromo->links() }}
    </div>
</div>
