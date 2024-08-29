<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use WireUi\Traits\Actions;
use Livewire\Component;

class AddRider extends Component
{
    use WithPagination;
    use WithFileUploads;
    use Actions;

    public $add_modal = false;
    public $edit_modal = false;
    public $search, $name, $contactnumber, $address, $platenumber, $email, $password;
    public $riderIdToEdit;

    protected $rules = [
        'name' => 'required|string|max:255',
        'contactnumber' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'platenumber' => 'required|string|max:20',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|string|min:8',
    ];

    public function render()
    {
        $search = '%' . $this->search . '%';
        return view('livewire.admin.add-rider', [
            'riders' => User::where('name', 'like', $search)
                            ->where('role', 2)
                            ->paginate(10),
        ]);
    }

    public function addrider()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'contactnumber' => $this->contactnumber,
            'address' => $this->address,
            'platenumber' => $this->platenumber,
            'email' => $this->email,
            'role' => 2,
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['name', 'contactnumber', 'address', 'platenumber', 'email', 'password', 'add_modal']);
        $this->notification()->success(
            $title = 'Rider Added!',
            $description = 'The rider was added successfully'
        );
    }

    public function editRider($riderId)
    {
        $rider = User::find($riderId);

        if ($rider) {
            $this->riderIdToEdit = $rider->id;
            $this->name = $rider->name;
            $this->contactnumber = $rider->contactnumber;
            $this->address = $rider->address;
            $this->platenumber = $rider->platenumber;
            $this->email = $rider->email;

            $this->edit_modal = true;
        } else {
            $this->notification()->error(
                $title = 'Error!',
                $description = 'The rider could not be found'
            );
        }
    }

    public function updateRider()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'contactnumber' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'platenumber' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:users,email,' . $this->riderIdToEdit,
        ]);

        $rider = User::find($this->riderIdToEdit);

        if ($rider) {
            $rider->update([
                'name' => $this->name,
                'contactnumber' => $this->contactnumber,
                'address' => $this->address,
                'platenumber' => $this->platenumber,
                'email' => $this->email,
            ]);

            $this->reset(['name', 'contactnumber', 'address', 'platenumber', 'email', 'password', 'edit_modal']);
            $this->notification()->success(
                $title = 'Rider Updated!',
                $description = 'The rider was updated successfully'
            );
        } else {
            $this->notification()->error(
                $title = 'Error!',
                $description = 'The rider could not be found'
            );
        }
    }

    public function deleteRider($riderId)
    {
        $rider = User::find($riderId);

        if ($rider) {
            $rider->delete();

            $this->notification()->success(
                $title = 'Rider Deleted!',
                $description = 'The rider was deleted successfully'
            );
        } else {
            $this->notification()->error(
                $title = 'Error!',
                $description = 'The rider could not be found'
            );
        }
    }

    public function close(){
         $this->edit_modal = false;
    }
}
