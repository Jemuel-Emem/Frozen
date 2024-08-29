<div>
    <div class="flex justify-end mb-4">

            <span class="text-right underline text-white">Your Order</span>

    </div>
    @foreach($orders as $order)
        <div class="mt-2">
            <x-card class="">
                <div class="md:grid grid-cols-4 ">
                <p>Order List: {{ $order->productlist }}</p>
                <p>Quantity: {{ $order->totalorder }}</p>
                <p>Price: ${{ $order->assignrider}}</p>
                <p>Status: {{ $order->status }}</p>
                </div>
            </x-card>
        </div>
    @endforeach
</div>
