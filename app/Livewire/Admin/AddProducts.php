<?php

namespace App\Livewire\Admin;

use App\Models\Products;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;
use Livewire\Component;

class AddProducts extends Component
{
    use WithFileUploads, Actions, WithPagination;

    public $add_modal = false;
    public $edit_modal = false;
    public $search, $productname, $price, $stocks, $category, $promos = false, $photo;
    public $productIdToDelete;
    public $productIdToEdit;

    protected $rules = [
        'productname' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'stocks' => 'required|integer|min:0',
        'category' => 'required|string|max:255',
        'promos' => 'boolean',
        'photo' => 'nullable|image|max:1024',
    ];

    public function render()
    {
        $search = '%' . $this->search . '%';
        return view('livewire.admin.add-products', [
            'products' => Products::where('productname', 'like', $search)->paginate(10),
        ]);
    }

    public function addproduct()
    {
        $this->validate();

        $photoPath = $this->photo ? $this->photo->store('photos', 'public') : null;

        Products::create([
            'productname' => $this->productname,
            'price' => $this->price,
            'category' => $this->category,
            'stocks' => $this->stocks,
            'promos' => $this->promos ? 'yes' : 'no',
            'photo' => $photoPath,
        ]);

        $this->reset(['productname', 'price', 'category', 'stocks', 'promos', 'photo', 'add_modal']);
        $this->notification()->success(
            $title = 'Product saved!',
            $description = 'The product was added successfully'
        );
    }

    public function delete($productId)
    {
        $this->productIdToDelete = $productId;

        $this->dialog()->confirm([
            'title'       => 'Are you sure?',
            'description' => 'Delete the product?',
            'icon'        => 'warning',
            'accept'      => [
                'label'  => 'Yes, delete it',
                'method' => 'deleteproduct',
                'params' => '',
            ],
            'reject' => [
                'label'  => 'No, cancel',
                'method' => '',
            ],
        ]);
    }

    public function deleteproduct()
    {
        $product = Products::find($this->productIdToDelete);

        if ($product) {
            $product->delete();

            $this->notification()->success(
                $title = 'Product deleted!',
                $description = 'The product was deleted successfully'
            );
        } else {
            $this->notification()->error(
                $title = 'Error!',
                $description = 'The product could not be found'
            );
        }

        $this->productIdToDelete = null;
    }

    public function edit($productId)
    {
        $product = Products::find($productId);

        if ($product) {
            $this->productIdToEdit = $product->id;
            $this->productname = $product->productname;
            $this->price = $product->price;
            $this->category = $product->category;
            $this->stocks = $product->stocks;
            $this->promos = $product->promos === 'yes';
            $this->photo = null;
            $this->edit_modal = true;
        } else {
            $this->notification()->error(
                $title = 'Error!',
                $description = 'The product could not be found'
            );
        }
    }

    public function updateproduct()
    {
        $this->validate();

        $product = Products::find($this->productIdToEdit);

        if ($product) {
            $photoPath = $this->photo ? $this->photo->store('photos', 'public') : $product->photo;

            $product->update([
                'productname' => $this->productname,
                'price' => $this->price,
                'category' => $this->category,
                'stocks' => $this->stocks,
                'promos' => $this->promos ? 'yes' : 'no',
                'photo' => $photoPath,
            ]);

            $this->reset(['productname', 'price', 'stocks', 'category', 'promos', 'edit_modal']);
            $this->notification()->success(
                $title = 'Product updated!',
                $description = 'The product was updated successfully'
            );
        } else {
            $this->notification()->error(
                $title = 'Error!',
                $description = 'The product could not be found'
            );
        }
    }


}
