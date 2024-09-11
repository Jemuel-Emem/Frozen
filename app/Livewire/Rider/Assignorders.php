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
            // Create Sale entry
            Sale::create([
                'productlist' => json_encode(json_decode($order->productlist)),
                'totalorder' => $order->totalorder,
            ]);

            // Delete the assigned order
            $order->delete();

            // Send success notification to the user
            $this->notification()->success(
                $title = 'Done',
                $description = 'Order confirmed successfully'
            );

            // Prepare and send SMS using Semaphore API
            $this->sendSMS($order->phonenumber, $order->totalorder);
        } else {
            dd("error");
        }
    }

    private function sendSMS($phoneNumber, $totalOrder)
    {
        // $ch = curl_init();

        // $parameters = array(
        //     'apikey' => '046125f45f4f187e838905df98273c4e',
        //     'number' => $phoneNumber,
        //     'message' => "Your order of Php {$totalOrder} has been confirmed. Thank you for shopping with us!",
        //     'sendername' => 'KaisFrozen'
        // );

        // curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        // $output = curl_exec($ch);
        // curl_close($ch);


    }
}
