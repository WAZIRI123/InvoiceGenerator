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
                    <x-custom-components.label>Description</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.description" />
                    @error('item.description') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-custom-components.label>Sale Price</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="number" step="0.0001" wire:model="item.sale_price" />
                    @error('item.sale_price') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>

                <div class="mt-4">
                    <x-custom-components.label>Purchase Price</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="number" step="0.0001" wire:model="item.purchase_price" />
                    @error('item.purchase_price') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>


            <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-custom-components.label>Category</x-custom-components.label>
                    <x-custom-components.select class="block mt-1 w-full" wire:model="item.category_id">
                        <option value="">Select a category...</option>
                        <!-- Loop through your categories to populate the options -->
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </x-custom-components.select>
                    @error('item.category_id') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>

                <div class="mt-4">
                    <x-custom-components.label>Quantity</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="number" step="1" wire:model="item.quantity" />
                    @error('item.quantity') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>



            <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-custom-components.label>Enabled</x-custom-components.label>
                    <x-custom-components.checkbox class="mt-1" wire:model="item.enabled" />
                    @error('item.enabled') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
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
                    <x-custom-components.label>Name</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.name" />
                    @error('item.name') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>

                <div class="mt-4">
                    <x-custom-components.label>Description</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.description" />
                    @error('item.description') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-custom-components.label>Sale Price</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="number" step="0.0001" wire:model="item.sale_price" />
                    @error('item.sale_price') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>

                <div class="mt-4">
                    <x-custom-components.label>Purchase Price</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="number" step="0.0001" wire:model="item.purchase_price" />
                    @error('item.purchase_price') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>


            <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-custom-components.label>Category</x-custom-components.label>
                    <x-custom-components.select class="block mt-1 w-full" wire:model="item.category_id">
                        <option value="">Select a category...</option>
                        <!-- Loop through your categories to populate the options -->
                        @if(isset($item['category_id']))
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $item['category_id'] == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                        @else
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                        @endif

                    </x-custom-components.select>
                    @error('item.category_id') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>

                <div class="mt-4">
                    <x-custom-components.label>Quantity</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="number" step="1" wire:model="item.quantity" />
                    @error('item.quantity') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-custom-components.label>Enabled</x-custom-components.label>
                    <x-custom-components.checkbox class="mt-1" wire:model="item.enabled" />
                    @error('item.enabled') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-custom-components.button wire:click="$set('confirmingItemEdit', false)">Cancel</x-custom-components.button>
            <x-custom-components.button mode="add" wire:loading.attr="disabled" wire:click="editItem()">Save</x-custom-components.button>
        </x-slot>
    </x-custom-components.dialog-modal>
</div>