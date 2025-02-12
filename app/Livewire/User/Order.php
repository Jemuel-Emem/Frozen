<?php


namespace App\Livewire\User;

use App\Models\assignorders as Orders;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Order extends Component
{
    public $orders;
    public $selectedOrderId;
    public $feedback;
    public $showModal = false;

    public function mount()
    {
        $this->loadOrders();
    }

    public function loadOrders()
    {
        $this->orders = Orders::where('user_id', Auth::id())->get();
    }

    public function openFeedbackModal($orderId)
    {
        $this->selectedOrderId = $orderId;
        $order = Orders::find($orderId);

        if ($order) {
            $this->feedback = $order->feedback ?? ''; // Load existing feedback if any
            $this->showModal = true;
        }
    }

    public function submitFeedback()
{
    if (!$this->selectedOrderId) {
        dd('No order ID selected');
        return;
    }

    $order = Orders::find($this->selectedOrderId);

    if (!$order) {
        dd("Order with ID {$this->selectedOrderId} not found in database");
    }

    if ($order->user_id !== Auth::id()) {
        dd("User mismatch: Logged-in user ID is " . Auth::id() . ", but order belongs to user ID " . $order->user_id);
    }


    $order->update(['feedback' => $this->feedback]);
    session()->flash('message', 'Feedback submitted successfully!');

    $this->resetModal();
    $this->loadOrders();
}


    public function resetModal()
    {
        $this->showModal = false;
        $this->selectedOrderId = null;
        $this->feedback = '';
    }

    public function render()
    {
        return view('livewire.user.order');
    }
}
