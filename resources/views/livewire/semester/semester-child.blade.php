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
                <x-tall-crud-label>Classes Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.classes_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.classes_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Description</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.description" />
                @error('item.description') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Start Date</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.start_date" />
                @error('item.start_date') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>End Date</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.end_date" />
                @error('item.end_date') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>

            <h2 class="mt-4">Subjects</h2>
            <div class="grid grid-cols-3">
                @foreach( $subjects as $c)
                <x-tall-crud-checkbox-wrapper class="mt-4">
                    <x-tall-crud-label>{{$c->name}}</x-tall-crud-label>
                    <x-tall-crud-checkbox value="{{ $c->id }}" class="ml-2" wire:model="checkedSubjects" />
                </x-tall-crud-checkbox-wrapper>
                @endforeach
            </div></div><div class="grid grid-cols-2 gap-8">

            <div class="grid grid-cols-3">
                <div class="mt-4">
                    <x-tall-crud-label>Class</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.class_id">
                        <option value="">Please Select</option>
                        @foreach($classes as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.class_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
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
                <x-tall-crud-label>Name</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.name" />
                @error('item.name') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Classes Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.classes_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.classes_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Description</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.description" />
                @error('item.description') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Start Date</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.start_date" />
                @error('item.start_date') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>End Date</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.end_date" />
                @error('item.end_date') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>

            <h2 class="mt-4">Subjects</h2>
            <div class="grid grid-cols-3">
                @foreach( $subjects as $c)
                <x-tall-crud-checkbox-wrapper class="mt-4">
                    <x-tall-crud-label>{{$c->name}}</x-tall-crud-label>
                    <x-tall-crud-checkbox value="{{ $c->id }}" class="ml-2" wire:model="checkedSubjects" />
                </x-tall-crud-checkbox-wrapper>
                @endforeach
            </div></div><div class="grid grid-cols-2 gap-8">

            <div class="grid grid-cols-3">
                <div class="mt-4">
                    <x-tall-crud-label>Class</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.class_id">
                        <option value="">Please Select</option>
                        @foreach($classes as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.class_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div></div>
        </x-slot>

        <x-slot name="footer">
            <x-tall-crud-button wire:click="$set('confirmingItemEdit', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="add" wire:loading.attr="disabled" wire:click="editItem()">Save</x-tall-crud-button>
        </x-slot>
    </x-tall-crud-dialog-modal>
</div>
