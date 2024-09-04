<?php

namespace App\Livewire\Admin;
use App\Models\products;
use App\Models\Order;
use App\Models\User;
use App\Models\AssignOrders;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    public $selectedRiders = [];

    public function render()
    {
        $orders = Order::paginate(10);
        $riders = User::where('role', 2)->pluck('name', 'id')->toArray(); // Fetch riders with role 2

        return view('livewire.admin.orders', [
            'orders' => $orders,
            'riders' => $riders,
        ]);
    }

    // public function assignRider($orderId)
    // {
    //     $order = Order::find($orderId);

    //     if ($order) {

    //         if (!isset($this->selectedRiders[$orderId])) {
    //             session()->flash('error', 'Please select a rider.');
    //             return;
    //         }

    //         $assignOrder = new AssignOrders();
    //         $assignOrder->user_id = $order->user_id;
    //         $assignOrder->name = $order->name;
    //         $assignOrder->address = $order->address;
    //         $assignOrder->phonenumber = $order->phonenumber;
    //         $assignOrder->productlist = $order->productlist;
    //         $assignOrder->totalorder = $order->totalorder;
    //         $assignOrder->status = "on-delivery";
    //         $assignOrder->quantity = 2;
    //         $assignOrder->assignrider = $this->selectedRiders[$orderId];
    //         $assignOrder->save();

    //         $order->delete();

    //         session()->flash('message', 'Rider assigned successfully and order deleted.');
    //     } else {
    //         session()->flash('error', 'Order not found.');
    //     }
    // }
    public function assignRider($orderId)
    {
        $order = Order::find($orderId);

        if ($order) {
            if (!isset($this->selectedRiders[$orderId])) {
                session()->flash('error', 'Please select a rider.');
                return;
            }


            $products = json_decode($order->productlist, true);
            foreach ($products as $product) {
                $productRecord = Products::where('productname', $product['productname'])->first();
                if ($productRecord) {
                    $productRecord->stocks -= $product['quantity'];
                    $productRecord->save();
                }
            }

            $assignOrder = new AssignOrders();
            $assignOrder->user_id = $order->user_id;
            $assignOrder->name = $order->name;
            $assignOrder->address = $order->address;
            $assignOrder->phonenumber = $order->phonenumber;
            $assignOrder->productlist = $order->productlist;
            $assignOrder->totalorder = $order->totalorder;
            $assignOrder->status = "on-delivery";
            $assignOrder->quantity = 2;
            $assignOrder->assignrider = $this->selectedRiders[$orderId];
            $assignOrder->save();

         
            $order->delete();

            session()->flash('message', 'Rider assigned successfully, product stock updated, and order deleted.');
        } else {
            session()->flash('error', 'Order not found.');
        }
    }

    public function declineOrder($orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->assignrider = null;
            $order->save();
            session()->flash('message', 'Rider assignment declined.');
        }
    }
}
