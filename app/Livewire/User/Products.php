<?php

namespace App\Livewire\User;

use App\Models\Cart;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;
use App\Models\Products as Product;
use Livewire\Component;

class Products extends Component
{
    use WithFileUploads, Actions, WithPagination;

    public $search;

    public function find(){

      $this->render();
    }
    public function render()
    {
        $search = '%' . $this->search . '%';


        $productsWithPromo = Product::where('productname', 'like', $search)
                                     ->where('promos', "yes")
                                     ->get();
        $productsWithoutPromo = Product::where('productname', 'like', $search)
                                        ->where('promos', "no")
                                        ->paginate(10);

        return view('livewire.user.products', [
            'productsWithPromo' => $productsWithPromo,
            'productsWithoutPromo' => $productsWithoutPromo,
        ]);
    }

    public function addToCart($id)
    {
        $product = Product::find($id);

        if ($product) {
            if (auth()->check()) {
                $user = auth()->user();

                Cart::create([
                    'user_id'      => $user->id,
                    'productname'  => $product->productname,
                    'category'     => $product->category,
                    'price'        => $product->price,
                    'photo'        => $product->photo,
                ]);

                $this->resetPage();

                $this->dialog([
                    'title'       => 'Added to cart',
                    'description' => 'The product was added to cart',
                    'icon'        => 'success',
                ]);
            } else {
                $this->dialog([
                    'title'       => 'Authentication Required',
                    'description' => 'Please log in to add products to your cart.',
                    'icon'        => 'error',
                ]);
            }
        } else {
            $this->dialog([
                'title'       => 'Product Not Found',
                'description' => 'The product could not be found.',
                'icon'        => 'error',
            ]);
        }
    }
}
