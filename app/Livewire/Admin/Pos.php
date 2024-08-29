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
    public $total, $change;
    public $reciept_modal = false;
    public function mount()
    {
        $this->products = Product::all();
        $this->cashAmount = 0;
        $this->total = 0;
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


    public function confirmPayment()
    {

        $this->clearOrder();
        $this->reciept_modal  = false;
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
        }
    }

    public function incrementQuantity($index)
    {
        $this->currentOrder[$index]['quantity']++;
    }

    public function decrementQuantity($index)
    {
        if ($this->currentOrder[$index]['quantity'] > 1) {
            $this->currentOrder[$index]['quantity']--;
        } else {
            unset($this->currentOrder[$index]);
            $this->currentOrder = array_values($this->currentOrder);
        }
    }

    private function updateProducts()
    {
        if ($this->category === 'All items') {
            $this->products = Product::all();
        } else {
            $this->products = Product::where('category', $this->category)->get();
        }
    }

    public function calculateChange()
    {
        $change = $this->cashAmount - $this->total;
        return $change >= 0 ? number_format($change, 2) : 0;
    }

public function render()
{
    // Calculate subtotal
    $subtotal = collect($this->currentOrder)->sum(function ($item) {
        return $item['price'] * $item['quantity'];
    });

    // Calculate total
    $this->total = $subtotal; // You can add tax or discounts here if needed

    return view('livewire.admin.pos', [
        'subtotal' => $subtotal,
        'total' => $this->total,
    ]);
}

    }

