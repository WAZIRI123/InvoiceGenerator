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
                <x-tall-crud-label>Name</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.name" />
                @error('item.name') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                    <x-tall-crud-label>Class</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.classes_id">
                        <option value="">Please Select</option>
                        @foreach($classes as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.classes_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
   
            </div>
        </div>

            <div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                    <x-tall-crud-label>Marks Distribution</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.marks_distribution_types">
                        <option value="">Please Select</option>
                        @foreach($marks_distribution_types as  $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.marks_distribution_types') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
   
            </div>
            <div class="mt-4">
                <x-tall-crud-label>open for marks entry</x-tall-crud-label>

                    <x-tall-crud-checkbox wire:model="item.open_for_marks_entry"  />
                    open for marks entry
         
            </div>
        </div>
        
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
                <x-tall-crud-label>Name</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.name" />
                @error('item.name') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                    <x-tall-crud-label>Class</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.classes_id">
                        <option value="">Please Select</option>
                        @foreach($classes as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.classes_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
   
            </div>
        </div>

            <div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                    <x-tall-crud-label>Marks Distribution</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.marks_distribution_types">
                        <option value="">Please Select</option>
                        @foreach($marks_distribution_types as  $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.marks_distribution_types') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
   
            </div>
            <div class="mt-4">
                <x-tall-crud-label>open for marks entry</x-tall-crud-label>

                    <x-tall-crud-checkbox wire:model="item.open_for_marks_entry"  />
                    open for marks entry
         
            </div></div>
        </x-slot>

        <x-slot name="footer">
            <x-tall-crud-button wire:click="$set('confirmingItemEdit', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="add" wire:loading.attr="disabled" wire:click="editItem()">Save</x-tall-crud-button>
        </x-slot>
    </x-tall-crud-dialog-modal>
</div>
