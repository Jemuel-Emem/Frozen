<div>
    <div class="flex justify-end">
        <x-button label="Add Rider" green icon="plus" wire:click="$set('add_modal', true)" class="w-64" />
    </div>

    <div class="relative overflow-x-auto mt-4">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Name</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Contact Number</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Address</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Plate Number</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black">Photo</th>
                    <th scope="col" class="px-6 py-3 text-gray-700 font-black text-center">Action</th>


                </tr>
            </thead>
            <tbody>
                @foreach ($riders as $rider)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap dark:text-white">{{ $rider->name }}</th>
                        <td class="px-6 py-4">{{ $rider->contactnumber }}</td>
                        <td class="px-6 py-4">{{ $rider->address }}</td>
                        <td class="px-6 py-4">{{ $rider->platenumber }}</td>
                        <td class="px-6 py-4">
                            @if($rider->photo)
                                <img src="{{ asset('storage/' . $rider->photo) }}" alt="Rider Photo" class="w-12 h-12 rounded-full object-cover">
                            @else
                                <span class="text-gray-400">No Photo</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            <x-button class="w-16 h-6" label="edit" icon="pencil-alt" wire:click="editRider({{ $rider->id }})" />
                            <x-button class="w-16 h-6" label="delete" icon="trash"
                                wire:click="deleteRider({{ $rider->id }})" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $riders->links() }}
    </div>

    <x-modal wire:model.defer="add_modal">
        <x-card title="Add Rider">
            <div class="space-y-3">
                <x-input label="Name" placeholder="" wire:model="name" />
                <x-input label="Contact Number" wire:model="contactnumber" placeholder="" />
                <x-input label="Address" placeholder="" wire:model="address" />
                <x-input label="Plate Number" placeholder="" wire:model="platenumber" />
                <x-input label="Email" placeholder="" wire:model="email" />
                <x-input label="Password" placeholder="" wire:model="password" type="password" />
                <x-input label="Photo" type="file" wire:model="photo" />
                @error('photo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button label="Add Rider" wire:click="addrider" spinner="addrider" green />
                </div>
            </x-slot>
        </x-card>
    </x-modal>

    <x-modal wire:model.defer="edit_modal">
        <x-card title="Edit Rider">
            <div class="space-y-3">
                <x-input label="Name" placeholder="" wire:model="name" />
                <x-input label="Contact Number" wire:model="contactnumber" placeholder="" />
                <x-input label="Address" placeholder="" wire:model="address" />
                <x-input label="Plate Number" placeholder="" wire:model="platenumber" />
                <x-input label="Email" placeholder="" wire:model="email" />
                <x-input label="Photo" type="file" wire:model="photo" />
                @error('photo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button label="Update Rider" wire:click="updateRider" green />
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
