<?php

namespace App\Livewire\Admin;
use App\Models\products as Product;
use WireUi\Traits\Actions;
use Livewire\Component;

class Pos extends Component
{
    use Actions;
    public $products;
    public $category = 'All items';
    public $currentOrder = [];
    public $cashAmount;
    public $change;
    public $reciept_modal = false;
    public $subtotal = 0;
    public $total = 0;
    public $vatRate = 12;
    public function mount()
    {
        $this->products = Product::all();
        $this->cashAmount = 0;
        $this->total = 0;
        $this->total = 0;
        $this->subtotal = 0;
    }

    public function pay()
    {

        $this->change = $this->cashAmount - $this->total;

        if ($this->cashAmount < $this->total) {
            $this->notification()->error(
                $title = 'Payment Error',
                $description = 'Cash amount is less than total amount. Please enter correct amount.'
            );
        } else {
            $this->reciept_modal = true;
        }
    }


    // public function paynow()
    // {

    //     \App\Models\Sale::create([
    //         'productlist' => json_encode($this->currentOrder),
    //         'totalorder' => $this->total,
    //     ]);


    //     $this->clearOrder();
    //     $this->reciept_modal = false;

    //     $this->notification()->success(
    //         $title = 'Payment Successful',
    //         $description = 'The payment has been confirmed and the order has been recorded.'
    //     );
    // }

    public function paynow()
{


    foreach ($this->currentOrder as $orderItem) {
        $product = Product::find($orderItem['id']);

        if ($product && $product->stocks < $orderItem['quantity']) {
            $this->notification()->error(
                $title = 'Stock Error',
                $description = "The product {$product->productname} does not have enough stock."
            );
            return;
        }
    }


    foreach ($this->currentOrder as $orderItem) {
        $product = Product::find($orderItem['id']);

        if ($product) {
            $product->stocks -= $orderItem['quantity'];
            $product->save();
        }
    }


    \App\Models\Sale::create([
        'productlist' => json_encode($this->currentOrder),
        'totalorder' => $this->total,
    ]);


    $this->clearOrder();
    $this->reciept_modal = false;

    $this->notification()->success(
        $title = 'Payment Successful',
        $description = 'The payment has been confirmed, the stock has been updated, and the order has been recorded.'
    );
}


    public function clearOrder()
    {
        $this->currentOrder = [];
    }

    public function setCategory($category)
    {
        $this->category = $category;
        $this->updateProducts();
    }

    public function addToOrder($productId)
    {
        $product = Product::find($productId);

        if ($product) {
            $existingProductKey = array_search($productId, array_column($this->currentOrder, 'id'));

            if ($existingProductKey !== false) {
                $this->currentOrder[$existingProductKey]['quantity']++;
            } else {
                $this->currentOrder[] = [
                    'id' => $product->id,
                    'productname' => $product->productname,
                    'price' => $product->price,
                    'photo' => $product->photo,
                    'quantity' => 1
                ];
            }

            $this->calculateTotal();
        }
    }

    // public function incrementQuantity($index)
    // {
    //     $this->currentOrder[$index]['quantity']++;
    //     $this->calculateTotal();
    // }

    public function incrementQuantity($index)
{
    $product = Product::find($this->currentOrder[$index]['id']);
    if ($product && $this->currentOrder[$index]['quantity'] < $product->stocks) {
        $this->currentOrder[$index]['quantity']++;
        $this->calculateTotal();
    } else {
        $this->notification()->error(
            'Stock Error',
            "Not enough stock available for {$product->productname}."
        );
    }
}


    public function decrementQuantity($index)
    {
        if ($this->currentOrder[$index]['quantity'] > 1) {
            $this->currentOrder[$index]['quantity']--;
        } else {
            unset($this->currentOrder[$index]);
            $this->currentOrder = array_values($this->currentOrder);
        }

        $this->calculateTotal();
    }
    public function calculateTotal()
    {
        $this->subtotal = collect($this->currentOrder)->sum(fn($item) => $item['price'] * $item['quantity']);
        $vatAmount = $this->subtotal * ($this->vatRate / 100);
        $this->total = $this->subtotal + $vatAmount; // This is the correct total
    }
    private function updateProducts()
    {
        if ($this->category === 'All items') {
            $this->products = Product::all();
        } else {
            $this->products = Product::where('category', $this->category)->get();
        }
    }

    // public function calculateChange()
    // {
    //     $change = $this->cashAmount - $this->total;
    //     return $change >= 0 ? number_format($change, 2) : 0;
    // }

    public function calculateChange()
{
    $this->change = max(0, $this->cashAmount - $this->total);
}


public function render()
{

    // $subtotal = collect($this->currentOrder)->sum(function ($item) {
    //     return $item['price'] * $item['quantity'];
    // });
    // $vatAmount = $subtotal * ($this->vatRate / 100);
    // // Calculate total
    // $this->total = $subtotal; // You can add tax or discounts here if needed

    // return view('livewire.admin.pos', [
    //     'subtotal' => $subtotal,
    //    'vatAmount' => $vatAmount,
    //     'total' => $this->total,
    // ]);

    $subtotal = collect($this->currentOrder)->sum(function ($item) {
        return $item['price'] * $item['quantity'];
    });

    // Calculate VAT and total
    $vatAmount = $subtotal * ($this->vatRate / 100);
    $this->total = $subtotal + $vatAmount;

    return view('livewire.admin.pos', [
        'subtotal' => $subtotal,
        'vatAmount' => $vatAmount,
        'total' => $this->total, // Make sure this is passed correctly
    ]);
}

    }

