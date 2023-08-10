<div>
    <!-- Deletion Confirmation Dialog -->
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

    <!-- Creation Dialog Modal -->
    <x-custom-components.dialog-modal wire:model.live="confirmingItemCreation">
        <x-slot name="title">
            Add Record
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-custom-components.label>Title</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.title" />
                    @error('item.title') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
                <div class="mt-4">
                    <x-custom-components.label>Description</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.description" />
                    @error('item.description') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                    <x-custom-components.label>Customer</x-custom-components.label>
                    <x-custom-components.select class="block mt-1 w-full" wire:model="item.customer_id">
                        <option value="">Select a customer or add a new one...</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                        <button type="submit" wire:click="$dispatchTo('customer.create', 'showCreateForm')" class="text-blue-500">
            <x-custom-components.icon-add />
        </button> 
                    </x-custom-components.select>
                    @error('item.customer_id') <x-custom-components.error-message>{{ $message }}</x-custom-components.error-message> @enderror
                </div>
                <div class="mt-4">
                    <x-custom-components.label>Invoice Date</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="date" wire:model="item.invoice_date" />
                    @error('item.invoice_date') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-custom-components.label>Invoice Number</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.invoice_number" />
                    @error('item.invoice_number') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
                <div class="mt-4">
                    <x-custom-components.label>Due Date</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="date" wire:model="item.due_date" />
                    @error('item.due_date') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-custom-components.label>Order Number</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.order_number" />
                    @error('item.order_number') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>

                <div class="mt-4">
                    <x-custom-components.label>Items</x-custom-components.label>

                    <table class="w-full whitespace-no-wrap mt-4 shadow-2xl text-xs" wire:loading.class.delay="opacity-50">
    <thead>
        <tr class="text-left font-bold bg-blue-400">
            <td class="px-3 py-2">
                <div class="flex items-center">
                    <button wire:click="sortBy('id')">Id</button>
                    <x-custom-components.sort-icon sortField="id" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                </div>
            </td>
            <td class="px-3 py-2">Name</td>
            <td class="px-3 py-2">Description</td>
            <td class="px-3 py-2">Sale Price</td>
            <td class="px-3 py-2">Purchase Price</td>
            <td class="px-3 py-2">Category</td>
        </tr>
    </thead>
    <tbody class="divide-y divide-blue-400">
    @foreach($item-list as $index => $row)
    <tr class="hover:bg-blue-300 {{ ($loop->even ) ? 'bg-blue-100' : ''}}">
        <td class="px-3 py-2">
            <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="items.{{ $index }}.name" />
        </td>
        <td class="px-3 py-2">
            <x-custom-components.input class="block mt-1 w-full" type="number" wire:model="items.{{ $index }}.quantity" />
        </td>
        <td class="px-3 py-2">
            <x-custom-components.input class="block mt-1 w-full" type="number" wire:model="items.{{ $index }}.price" />
        </td>
   </tr>
@endforeach

<tr class="hover:bg-blue-300 {{ ($loop->even ) ? 'bg-blue-100' : ''}}" ><td class="px-3 py-2">

<div class="mt-4">
                    <x-custom-components.label>item</x-custom-components.label>
                    <x-custom-components.select class="block mt-1 w-full" wire:model="item.item_id">
                        <option value="">Select a item or add a new one...</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                        <button type="submit" wire:click="$dispatchTo('item.create', 'showCreateForm')" class="text-blue-500">
            <x-custom-components.icon-add />
        </button> 
                    </x-custom-components.select>
                </div>
</td></tr>
<tr class="hover:bg-blue-300 {{ ($loop->even ) ? 'bg-blue-100' : ''}}">
<td class="px-3 py-2">    
     <button type="submit" wire:click="$dispatchTo('item.create', 'showSelectItem')" class="text-blue-500">
            <x-custom-components.icon-add />
     </button> </td>
</tr>

    </tbody>
</table>
                    <x-custom-components.select class="block mt-1 w-full" wire:model="item.category_id">
                        <option value="">Select a item...</option>
                        <!-- Loop through your categories to populate the options -->
                        @foreach($items as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </x-custom-components.select>
                    @error('item.item_id') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-custom-components.label>Quantity</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="number" step="1" wire:model="item.quantity" />
                    @error('item.quantity') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
                <div class="mt-4">
                    <x-custom-components.label>Notes</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.notes" />
                    @error('item.notes') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-custom-components.button wire:click="$set('confirmingItemCreation', false)">Cancel</x-custom-components.button>
            <x-custom-components.button mode="add" wire:loading.attr="disabled" wire:click="createItem()">Save</x-custom-components.button>
        </x-slot>
    </x-custom-components.dialog-modal>

    <!-- Edit Dialog Modal -->
    <x-custom-components.dialog-modal wire:model.live="confirmingItemEdit">
        <x-slot name="title">
            Edit Record
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-custom-components.label>Title</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.title" />
                    @error('item.title') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
                <div class="mt-4">
                    <x-custom-components.label>Description</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.description" />
                    @error('item.description') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                    <x-custom-components.label>Customer</x-custom-components.label>
                    <x-custom-components.select class="block mt-1 w-full" wire:model="item.customer_id">
                        <option value="">Select a customer or add a new one...</option>
                        @if(isset($item['customer_id']))
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}"  {{ $item['customer_id'] == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                        @endforeach
                        @else
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                        <button type="submit" wire:click="$dispatchTo('customer.create', 'showCreateForm')" class="text-blue-500">
            <x-custom-components.icon-add />
        </button> 
                    </x-custom-components.select>
                    @error('item.customer_id') <x-custom-components.error-message>{{ $message }}</x-custom-components.error-message> @enderror
                </div>
                <div class="mt-4">
                    <x-custom-components.label>Invoice Date</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="date" wire:model="item.invoice_date" />
                    @error('item.invoice_date') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-custom-components.label>Invoice Number</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.invoice_number" />
                    @error('item.invoice_number') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
                <div class="mt-4">
                    <x-custom-components.label>Due Date</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="date" wire:model="item.due_date" />
                    @error('item.due_date') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-custom-components.label>Order Number</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.order_number" />
                    @error('item.order_number') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
                <div class="mt-4">
                    <x-custom-components.label>Items</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.items" />
                    @error('item.items') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-custom-components.label>Quantity</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="number" step="1" wire:model="item.quantity" />
                    @error('item.quantity') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
                <div class="mt-4">
                    <x-custom-components.label>Notes</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.notes" />
                    @error('item.notes') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-custom-components.button wire:click="$set('confirmingItemEdit', false)">Cancel</x-custom-components.button>
            <x-custom-components.button mode="add" wire:loading.attr="disabled" wire:click="editItem()">Save</x-custom-components.button>
        </x-slot>
    </x-custom-components.dialog-modal>
</div>
