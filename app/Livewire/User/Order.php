<?php

namespace App\Livewire\User;
use App\Models\assignorders as Orders;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Order extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Orders::where('user_id', Auth::id())->get();
    }

    public function render()
    {
        return view('livewire.user.order');
    }
}
