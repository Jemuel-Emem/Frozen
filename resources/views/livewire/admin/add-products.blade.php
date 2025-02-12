<div>
    <div class="flex justify-end">
        <x-button label="Add Products" green icon="plus" wire:click="$set('add_modal', true)" class="w-64" />
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="relative overflow-x-auto mt-4">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Product name</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Price</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Promo</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Category</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Photo</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Stocks</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap dark:text-white">{{ $product->productname }}</th>
                        <td class="px-6 py-4">{{ $product->price }}</td>
                        <td class="px-6 py-4">{{ $product->promos }}</td>
                        <td class="px-6 py-4">{{ $product->category }}</td>
                        <td class="px-6 py-4">
                            @if ($product->photo)
                                <img src="{{ asset('storage/' . $product->photo) }}" alt="Product Photo" class="w-16 h-16 object-cover">
                            @else
                                No photo
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $product->stocks }}</td>
                        <td class="px-6 py-4 text-center">
                            <x-button class="w-16 h-6" label="edit" icon="pencil-alt" wire:click="edit({{ $product->id }})" />
                            <x-button class="w-16 h-6" label="delete" icon="trash" wire:click="delete({{ $product->id }})" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $products->links() }}
    </div>

    <x-modal wire:model.defer="add_modal">
        <x-card title="Add Products">
            <div class="space-y-3">
                <x-input label="Product Name" placeholder="" wire:model="productname" />
                <x-input label="Price" wire:model="price" placeholder="" />
                <x-checkbox id="promo-checkbox" label="Promo?" wire:model.defer="promos" />
                <x-input label="Stocks" placeholder="" wire:model="stocks" />
                <x-select label="Category" placeholder="Select category" :options="[ 'Pork', 'Chicken', 'Beef']" wire:model.defer="category" />
                <x-input type="file" label="Photo" placeholder="" wire:model="photo" />
            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button label="Add Product" wire:click="addproduct" spinner="addproduct" green />
                </div>
            </x-slot>
        </x-card>
    </x-modal>

    <x-modal wire:model.defer="edit_modal">
        <x-card title="Edit Products">
            <div class="space-y-3">
                <x-input label="Product Name" placeholder="" wire:model="productname" />
                <x-input label="Price" wire:model="price" placeholder="" />
                <x-checkbox id="promo-checkbox-edit" label="Promo?" wire:model.defer="promos" />
                <x-input label="Stocks" placeholder="" wire:model="stocks" />
                <x-select label="Category" placeholder="Select category" :options="[ 'Pork', 'Chicken', 'Beef']" wire:model.defer="category" />
                <x-input type="file" label="Photo" placeholder="" wire:model="photo" />
            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button label="Update Product" wire:click="updateproduct" spinner="updateproduct" green />
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
