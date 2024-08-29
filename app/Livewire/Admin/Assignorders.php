<?php

namespace App\Livewire\Admin;
use App\Models\assignorders as ass;
use Livewire\Component;

class Assignorders extends Component
{
    public function render()
    {
        $assignedOrders = ass::all();

        return view('livewire.admin.assignorders', [
            'assignedOrders' => $assignedOrders,
        ]);
    }
}
