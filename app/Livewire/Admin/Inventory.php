<?php
namespace App\Livewire\Admin;

use App\Models\Products;
use Livewire\Component;
use Livewire\WithPagination;

class Inventory extends Component
{
    use WithPagination;

    public $stockAmount, $productId;
    public $showModal = false;

    public function openStockModal($productId)
    {
        $this->productId = $productId;
        $this->stockAmount = '';
        $this->showModal = true;
    }

    public function addStock()
    {
        $this->validate([
            'stockAmount' => 'required|integer|min:1',
        ]);

        $product = Products::find($this->productId);
        if ($product) {
            $product->increment('stocks', $this->stockAmount);
            session()->flash('message', 'Stock added successfully!');
        }

        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.admin.inventory', [
            'products' => Products::paginate(10),
        ]);
    }
}
