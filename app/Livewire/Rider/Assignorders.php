<?php

namespace App\Livewire\Rider;
use App\Models\assignorders as assignorder;
Use App\Models\Sale;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Assignorders extends Component
{
    use Actions;
    public function render()
    {

        $assignedOrders = AssignOrder::where('assignrider', Auth::user()->name)->get();

        return view('livewire.rider.assignorders', [
            'assignedOrders' => $assignedOrders,
        ]);
    }

    public function confirmOrder($orderId)
    {

        $order = AssignOrder::find($orderId);

        if ($order) {
            Sale::create([
                'productlist' => json_encode(json_decode($order->productlist)),
                'totalorder' => $order->totalorder,
            ]);


            $order->delete();

            $this->notification()->success(
                $title = 'Done',
                $description = 'Order Confirm successfully'
            );
        } else {
           dd("error");
        }
    }
}
