<?php

namespace App\Livewire\User;
use App\Models\Order as order;
use App\Models\Cart as Cart;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;
use Livewire\Component;

class Carts extends Component
{
    use WithPagination, Actions, WithFileUploads;

    public $agree = false;
    public $open_modal = false;
    public $selectedProducts = [];
    public $selectedProductList = [];
    public $search, $totalPrice = 0;
    public $quantities = [];

    public function mount()
    {
        $this->updatedSelectedProducts();
        $products = Cart::all();
        foreach ($products as $product) {
            $this->quantities[$product->id] = 1;
        }
    }

    protected $rules = [
        'agree' => 'accepted',
    ];

    public function render()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $userCarts = Cart::where('user_id', $user->id)
                         ->where('productname', 'like', '%' . $this->search . '%')
                         ->paginate(12);

        return view('livewire.user.carts', [
            'product' => $userCarts,
        ]);
    }

    public function toggleAgree()
    {
        $this->validateOnly('agree');
    }

    public function add($productId)
    {
        $this->selectedProducts[$productId] = !$this->selectedProducts[$productId];
        $this->calculateTotalPrice();
    }

    public function calculateTotalPrice()
    {
        $totalPrice = 0;
        $this->selectedProductList = [];

        $products = Cart::all();

        foreach ($this->selectedProducts as $productId => $isSelected) {
            if ($isSelected) {
                $product = $products->find($productId);
                if ($product) {
                    $totalPrice += $product->price * $this->quantities[$productId];
                    $this->selectedProductList[] = $product;
                }
            }
        }

        $this->totalPrice = $totalPrice;

        // Only open the modal if there are selected products
        if (count($this->selectedProductList) > 0) {
            $this->open_modal = true;
        } else {
            $this->open_modal = false;
        }

        return $totalPrice;
    }

    public function updatedSelectedProducts()
    {
        $this->calculateTotalPrice();
    }

    public function delete($id)
    {
        $cartItem = Cart::find($id);
        if ($cartItem) {
            $cartItem->delete();
            $this->dialog([
                'title' => 'Deleted from cart',
                'description' => 'The product was removed from the cart',
                'icon' => 'error'
            ]);

            $this->resetPage();
        }
    }

    public function ordernow()
    {



        $selectedProductList = $this->getSelectedProducts();
        $totalPrice = $this->calculateTotalPrice();

         Order::create([
             'user_id'=> auth()->user()->id,
             'name' => auth()->user()->name,
             'address' => auth()->user()->address,
             'phonenumber' => auth()->user()->contactnumber,
             'productlist' => json_encode($selectedProductList, JSON_UNESCAPED_UNICODE),
             'totalorder' => $totalPrice,
         ]);

        $this->deleteSelectedProducts();
        $this->resetSelectedProducts();
        $this->resetTotalPrice();

        $this->dialog()->show([
            'title'       => 'Order ',
            'description' => 'Your order was successfully processed',
            'icon'        => 'success'
        ]);

        $this->open_modal = false;
    }

    protected function getSelectedProducts()
    {
        $selectedProductList = [];

        foreach ($this->selectedProducts as $productId => $isSelected) {
            if ($isSelected) {
                $product = Cart::find($productId);
                if ($product) {
                    $selectedProductList[] = $product->productname;
                }
            }
        }

        return $selectedProductList;
    }

    protected function resetSelectedProducts()
    {
        $this->selectedProducts = [];
    }

    protected function resetTotalPrice()
    {
        $this->totalPrice = 0;
    }

    protected function deleteSelectedProducts()
    {
        foreach ($this->selectedProducts as $productId => $isSelected) {
            if ($isSelected) {
                Cart::find($productId)->delete();
            }
        }
    }
}
