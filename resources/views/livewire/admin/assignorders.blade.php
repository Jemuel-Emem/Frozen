<div>
    <div class="relative overflow-x-auto mt-4">

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Assigned Rider</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Name</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Address</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Phonenumber</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Product List</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Total Order</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assignedOrders as $assignedOrder)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $assignedOrder->assignrider }}</td>
                        <td class="px-6 py-4">{{ $assignedOrder->name }}</td>
                        <td class="px-6 py-4">{{ $assignedOrder->address }}</td>
                        <td class="px-6 py-4">{{ $assignedOrder->phonenumber }}</td>
                        <td class="px-6 py-4">{{ implode(', ', json_decode($assignedOrder->productlist)) }}</td>
                        <td class="px-6 py-4">{{ $assignedOrder->totalorder }} Php</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
