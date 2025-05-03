<div class="p-6 bg-white shadow-md rounded">

    <div id="printSection">
        <table class="w-full table-auto border border-gray-300">
            <thead class="bg-gray-100">
                <tr>

                    <th class="border px-4 py-2">Product List</th>
                    <th class="border px-4 py-2">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>

                        <td class="border px-4 py-2 text-center">
                            @php
                                $raw = $order->productlist;
                                $products = json_decode($raw, true);
                                if (is_string($products)) {
                                    $products = json_decode($products, true);
                                }
                            @endphp

                            @if (is_array($products))
                                {{ implode(', ', array_column($products, 'productname')) }}
                            @else
                                Invalid product list
                            @endif
                        </td>
                        <td class="border px-4 py-2 text-center">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 py-4">No sales found.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>


