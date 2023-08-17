<div>

    <x-custom-components.confirmation-dialog wire:model.live="confirmingItemDeletion">
        <x-slot name="title">
            Delete Record
        </x-slot>

        <x-slot name="content">
            Are you sure you want to delete this record?
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
                    <x-custom-components.label>Visitor Name</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.visitorName" />
                    @error('item.visitorName') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
                <div class="mt-4">
                    <x-custom-components.label>Arrival Date</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="date" wire:model="item.arrivalDate" />
                    @error('item.arrivalDate') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>
         
        <div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-custom-components.label>Safari Start Date</x-custom-components.label>
                <x-custom-components.input class="block mt-1 w-full" type="date" wire:model="item.safariStartDate" />
                @error('item.safariStartDate') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
            </div>
            <div class="mt-4">
                <x-custom-components.label>Safari End Date</x-custom-components.label>
                <x-custom-components.input class="block mt-1 w-full" type="date" wire:model="item.safariEndDate" />
                @error('item.safariEndDate') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8">

        <div class="mt-4">
                    <x-custom-components.label>Car</x-custom-components.label>
                    <x-custom-components.select class="block mt-1 w-full" wire:model="item.carNumber">
                        <option value="">Select a car...</option>
                        <!-- Loop through your categories to populate the options -->
                        @foreach($cars as $car)
                        <option value="{{ $car->car_number }}">{{ $car->name }}</option>
                        @endforeach
                    </x-custom-components.select>
                    @error('item.carNumber') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            <div class="mt-4">
                <x-custom-components.label>Guide Name</x-custom-components.label>
                <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.guideName" />
                @error('item.guideName') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-custom-components.label>Special Event</x-custom-components.label>
                <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.specialEvent" />
                @error('item.specialEvent') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
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

        <x-slot name="content">
            <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-custom-components.label>Visitor Name</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.visitorName" />
                    @error('item.visitorName') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
                <div class="mt-4">
                    <x-custom-components.label>Arrival Date</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="date" wire:model="item.arrivalDate" />
                    @error('item.arrivalDate') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>
        
            <div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-custom-components.label>Safari Start Date</x-custom-components.label>
                <x-custom-components.input class="block mt-1 w-full" type="date" wire:model="item.safariStartDate" />
                @error('item.safariStartDate') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
            </div>
            <div class="mt-4">
                <x-custom-components.label>Safari End Date</x-custom-components.label>
                <x-custom-components.input class="block mt-1 w-full" type="date" wire:model="item.safariEndDate" />
                @error('item.safariEndDate') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8">
        <div class="mt-4">
                    <x-custom-components.label>Car</x-custom-components.label>
                    <x-custom-components.select class="block mt-1 w-full" wire:model="item.carNumber">
                        <option value="">Select a car...</option>
                        <!-- Loop through your categories to populate the options -->
                        @if(isset($item['carNumber']))
                        @foreach($cars as $car)
                        <option value="{{ $car->car_number }}" {{ $item['carNumber'] == $car->carNumber ? 'selected' : '' }}>{{ $car->name }}</option>
                        @endforeach
                        @else
                        @foreach($cars as $car)
                        <option value="{{ $car->car_number }}">{{ $car->name }}</option>
                        @endforeach
                        @endif
                    </x-custom-components.select>
                    @error('item.carNumber') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            <div class="mt-4">
                <x-custom-components.label>Guide Name</x-custom-components.label>
                <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.guideName" />
                @error('item.guideName') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-custom-components.label>Special Event</x-custom-components.label>
                <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.specialEvent" />
                @error('item.specialEvent') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
            </div>
        </div>

        </x-slot>

        <x-slot name="footer">
            <x-custom-components.button wire:click="$set('confirmingItemEdit', false)">Cancel</x-custom-components.button>
            <x-custom-components.button mode="add" wire:loading.attr="disabled" wire:click="editItem()">Save</x-custom-components.button>
        </x-slot>
    </x-custom-components.dialog-modal>
</div>
