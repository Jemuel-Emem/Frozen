<?php

namespace App\Livewire\Rider;
use App\Models\assignorders as assignorder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Assignorders extends Component
{
    public function render()
    {

        $assignedOrders = AssignOrder::where('assignrider', Auth::user()->name)->get();

        return view('livewire.rider.assignorders', [
            'assignedOrders' => $assignedOrders,
        ]);
    }
}
