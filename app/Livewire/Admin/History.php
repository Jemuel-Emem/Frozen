<?php

namespace App\Livewire\Admin;
use App\Models\sales;
use Livewire\Component;

class History extends Component
{
    public $orders;
    public $totalIncome;
    public function render()
    {
        $this->orders = sales::all();  // No status filtering needed unless you add a 'status' field
        $this->totalIncome = $this->orders->sum('totalorder');
        return view('livewire.admin.history');
    }
}
