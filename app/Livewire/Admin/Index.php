<?php

namespace App\Livewire\Admin;

use App\Livewire\Admin\Assignorders as AdminAssignorders;
use App\Models\Sale;
use App\Models\User; // Import User model
use App\Models\assignorders;// Import Order model
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    public $dailySales;
    public $weeklySales;
    public $monthlySales;
    public $yearlySales;
    public $totalIncome;
    public $numberOfUsers;
    public $assignedOrders;

    public function mount()
    {
        $this->dailySales = $this->getSalesByPeriod('daily');
        $this->weeklySales = $this->getSalesByPeriod('weekly');
        $this->monthlySales = $this->getSalesByPeriod('monthly');
        $this->yearlySales = $this->getSalesByPeriod('yearly');

        $this->totalIncome = $this->getTotalIncome();
        $this->numberOfUsers = $this->getNumberOfUsers();
        $this->assignedOrders = $this->getAssignedOrders();
    }

    public function render()
    {
        return view('livewire.admin.index', [
            'dailySales' => $this->dailySales,
            'weeklySales' => $this->weeklySales,
            'monthlySales' => $this->monthlySales,
            'yearlySales' => $this->yearlySales,
            'totalIncome' => $this->totalIncome,
            'numberOfUsers' => $this->numberOfUsers,
            'assignedOrders' => $this->assignedOrders,
        ]);
    }

    private function getSalesByPeriod($period)
    {
        switch ($period) {
            case 'daily':
                return Sale::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(totalorder) as total'))
                    ->whereDate('created_at', '=', today())
                    ->groupBy('date')
                    ->pluck('total', 'date')
                    ->toArray();

            case 'weekly':
                return Sale::select(DB::raw('WEEK(created_at) as week'), DB::raw('YEAR(created_at) as year'), DB::raw('SUM(totalorder) as total'))
                    ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                    ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('WEEK(created_at)'))
                    ->get()
                    ->mapWithKeys(function ($item) {
                        return [ "{$item->year}-W{$item->week}" => $item->total ];
                    })
                    ->toArray();

            case 'monthly':
                return Sale::select(DB::raw('MONTH(created_at) as month'), DB::raw('YEAR(created_at) as year'), DB::raw('SUM(totalorder) as total'))
                    ->whereYear('created_at', '=', now()->year)
                    ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                    ->get()
                    ->mapWithKeys(function ($item) {
                        return [ "{$item->year}-M{$item->month}" => $item->total ];
                    })
                    ->toArray();

            case 'yearly':
                return Sale::select(DB::raw('YEAR(created_at) as year'), DB::raw('SUM(totalorder) as total'))
                    ->groupBy('year')
                    ->get()
                    ->mapWithKeys(function ($item) {
                        return [ $item->year => $item->total ];
                    })
                    ->toArray();

            default:
                return [];
        }
    }

    private function getTotalIncome()
    {
        return Sale::sum('totalorder');
    }

    private function getNumberOfUsers()
    {
        return User::count();
    }

    private function getAssignedOrders()
    {
        return Assignorders::where('status', 'on-delivery')->count();
    }
}
