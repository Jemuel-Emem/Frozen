<?php
namespace App\Livewire\Admin;

use App\Models\assignorders;
use Livewire\Component;
use Livewire\WithPagination;

class Feedback extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $feedbacks = assignorders::whereNotNull('feedback')->paginate(10); // Use paginate instead of get()

        return view('livewire.admin.feedback', [
            'feedbacks' => $feedbacks
        ]);
    }
}
