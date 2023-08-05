<div>

    <x-custom-components.confirmation-dialog wire:model.live="confirmingItemDeletion">
        <x-slot name="title">
            Delete Record
        </x-slot>

        <x-slot name="content">
            Are you sure you want to Delete Record?
        </x-slot>

        <x-slot name="footer">
            <x-custom-components.button wire:click="$set('confirmingItemDeletion', false)">Cancel</x-custom-components.button>
            <x-custom-components.button mode="delete" wire:loading.attr="disabled" wire:click="deleteItem()">Delete</x-custom-components.button>
        </x-slot>
    </x-custom-components.confirmation-dialog>

    <x-custom-components.dialog-modal wire:model.live="confirmingItemCreation">
        <x-slot name="title">
            Add Record
        </x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-custom-components.label>Name</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.name" />
                    @error('item.name') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
                <div class="mt-4">
                    <x-custom-components.label>Email</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.email" />
                    @error('item.email') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-custom-components.button wire:click="$set('confirmingItemCreation', false)">Cancel</x-custom-components.button>
            <x-custom-components.button mode="add" wire:loading.attr="disabled" wire:click="createItem()">Save</x-custom-components.button>
        </x-slot>
    </x-custom-components.dialog-modal>

    <x-custom-components.dialog-modal wire:model.live="confirmingItemEdit">
        <x-slot name="title">
            Edit Record
        </x-slot>

        <x-slot name="content"><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-custom-components.label>Name</x-custom-components.label>
                <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.name" />
                @error('item.name') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
            </div>
            <div class="mt-4">
                <x-custom-components.label>Email</x-custom-components.label>
                <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.email" />
                @error('item.email') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
            </div>
        </div>
        </x-slot>

        <x-slot name="footer">
            <x-custom-components.button wire:click="$set('confirmingItemEdit', false)">Cancel</x-custom-components.button>
            <x-custom-components.button mode="add" wire:loading.attr="disabled" wire:click="editItem()">Save</x-custom-components.button>
        </x-slot>
    </x-custom-components.dialog-modal>
</div>
