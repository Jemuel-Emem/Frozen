<div class="p-6 bg-white shadow-md rounded-lg">
    @if(session()->has('message'))
        <div class="text-green-500 mb-4">{{ session('message') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Product Name</th>
                    <th class="border border-gray-300 px-4 py-2">Category</th>
                    <th class="border border-gray-300 px-4 py-2">Stocks</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="border-b">
                        <td class="border border-gray-300 px-4 text-center">{{ $product->productname }}</td>
                        <td class="border border-gray-300 px-4 text-center">{{ $product->category }}</td>
                        <td class="border border-gray-300 px-4 text-center">{{ $product->stocks }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <button wire:click="openStockModal({{ $product->id }})"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                Add Stock
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>


    @if($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                <h2 class="text-lg font-bold mb-4">Add Stock</h2>

                <input wire:model="stockAmount" type="number" class="w-full border rounded-md p-2 mb-2"
                    placeholder="Enter stock quantity">

                <div class="flex justify-end mt-4">
                    <button wire:click="$set('showModal', false)" class="bg-gray-400 text-white px-4 py-2 rounded-md mr-2">
                        Cancel
                    </button>
                    <button wire:click="addStock" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                        Add Stock
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
