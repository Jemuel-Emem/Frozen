<div>
    <div class="relative overflow-x-auto mt-4">
        @if (session()->has('message'))
            <div class="bg-green-500 text-white p-4 mb-4">
                {{ session('message') }}
            </div>
        @endif

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Name</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Address</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Phonenumber</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Product List</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Total Order</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Status</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black text-center">Rider</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap dark:text-white">{{ $order->name }}</th>
                        <td class="px-6 py-4">{{ $order->address }}</td>
                        <td class="px-6 py-4">{{ $order->phonenumber }}</td>
                        <td class="px-6 py-4">{{ implode(', ', json_decode($order->productlist)) }}</td>
                        <td class="px-6 py-4">{{ $order->totalorder }} Php</td>
                        <td class="px-6 py-4">{{ $order->orderstatus }}</td>
                        <td class="px-6 py-4 text-center flex gap-2">
                            <div class="w-full max-w-xs mx-auto">
                                <select
                                    class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                                    wire:model="selectedRiders.{{ $order->id }}"
                                >
                                    <option value="" disabled>Select a rider</option>
                                    @foreach ($riders as $riderName)
                                        <option value="{{ $riderName }}">{{ $riderName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="">

                                    <button class="w-32 bg-green-500 text-white" wire:click="assignRider({{ $order->id }})">Assign Rider</button>
                                    <button class="w-32 bg-red-500 text-white mt-2" wire:click="declineOrder({{ $order->id }})">Decline</button>
                           
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $orders->links() }}
    </div>
</div>
