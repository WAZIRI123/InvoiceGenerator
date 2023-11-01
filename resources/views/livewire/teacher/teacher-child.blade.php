<div>

    <x-tall-crud-confirmation-dialog wire:model.live="confirmingItemDeletion">
        <x-slot name="title">
            Delete Record
        </x-slot>

        <x-slot name="content">
            Are you sure you want to Delete Record?
        </x-slot>

        <x-slot name="footer">
            <x-tall-crud-button wire:click="$set('confirmingItemDeletion', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="delete" wire:loading.attr="disabled" wire:click="deleteItem()">Delete</x-tall-crud-button>
        </x-slot>
    </x-tall-crud-confirmation-dialog>

    <x-tall-crud-dialog-modal wire:model.live="confirmingItemCreation">
        <x-slot name="title">
            Add Record
        </x-slot>

        <x-slot name="content"><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>User Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.user_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.user_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Date Of Birth</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.date_of_birth" />
                @error('item.date_of_birth') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Registration No</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.registration_no" />
                @error('item.registration_no') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Date Of Employment</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.date_of_employment" />
                @error('item.date_of_employment') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Gender Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.gender_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.gender_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>

            <h2 class="mt-4">Classes</h2>
            <div class="grid grid-cols-3">
                @foreach( $classes as $c)
                <x-tall-crud-checkbox-wrapper class="mt-4">
                    <x-tall-crud-label>{{$c->name}}</x-tall-crud-label>
                    <x-tall-crud-checkbox value="{{ $c->id }}" class="ml-2" wire:model="checkedClasses" />
                </x-tall-crud-checkbox-wrapper>
                @endforeach
            </div></div>
        </x-slot>

        <x-slot name="footer">
            <x-tall-crud-button wire:click="$set('confirmingItemCreation', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="add" wire:loading.attr="disabled" wire:click="createItem()">Save</x-tall-crud-button>
        </x-slot>
    </x-tall-crud-dialog-modal>

    <x-tall-crud-dialog-modal wire:model.live="confirmingItemEdit">
        <x-slot name="title">
            Edit Record
        </x-slot>

        <x-slot name="content"><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>User Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.user_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.user_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Date Of Birth</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.date_of_birth" />
                @error('item.date_of_birth') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Registration No</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.registration_no" />
                @error('item.registration_no') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Date Of Employment</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.date_of_employment" />
                @error('item.date_of_employment') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Gender Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.gender_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.gender_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>

            <h2 class="mt-4">Classes</h2>
            <div class="grid grid-cols-3">
                @foreach( $classes as $c)
                <x-tall-crud-checkbox-wrapper class="mt-4">
                    <x-tall-crud-label>{{$c->name}}</x-tall-crud-label>
                    <x-tall-crud-checkbox value="{{ $c->id }}" class="ml-2" wire:model="checkedClasses" />
                </x-tall-crud-checkbox-wrapper>
                @endforeach
            </div></div>
        </x-slot>

        <x-slot name="footer">
            <x-tall-crud-button wire:click="$set('confirmingItemEdit', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="add" wire:loading.attr="disabled" wire:click="editItem()">Save</x-tall-crud-button>
        </x-slot>
    </x-tall-crud-dialog-modal>
</div>
