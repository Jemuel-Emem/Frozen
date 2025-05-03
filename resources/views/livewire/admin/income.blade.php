<div class="p-6 bg-white shadow-md rounded">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Sales Income</h2>
        <button onclick="printTable()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Print</button>
    </div>

    <div id="printSection">
        <table class="w-full table-auto border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Product List</th>
                    <th class="border px-4 py-2">Total Order (Php)</th>
                    <th class="border px-4 py-2">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $order->id }}</td>
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
                        <td class="border px-4 py-2 text-center">{{ number_format($order->totalorder, 2) }}</td>
                        <td class="border px-4 py-2 text-center">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 py-4">No sales found.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="bg-gray-200 font-semibold">
                    <td colspan="2" class="text-right px-4 py-2">Total Income:</td>
                    <td class="px-4 py-2">{{ number_format($totalIncome, 2) }} Php</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- Print Script -->
<script>
    function printTable() {
        const printContent = document.getElementById('printSection').innerHTML;
        const originalContent = document.body.innerHTML;

        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        location.reload(); // reload to restore JS functionality
    }
</script>
