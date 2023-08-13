<div class="h-full bg-gray-200 px-8">
<div class="mt-2 min-h-screen mb-8">

   <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-custom-components.label>Title</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.title" />
                    @error('item.title') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
                <div class="mt-4">
                    <x-custom-components.label>subheading</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.subheading" />
                    @error('item.subheading') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>


   <div class="grid grid-cols-2 gap-8">
      <div class="mt-4">
                    <x-custom-components.label>Company Name</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.companyName" />
                    @error('item.companyName') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
                <div class="mt-4">
                    <x-custom-components.label>logo</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="file" wire:model.live="item.logo" />
                    @error('item.logo') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8">
      <div class="mt-4">
                    <x-custom-components.label>Company Email</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.companyEmail" />
                    @error('item.companyEmail') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
                <div class="mt-4">
                    <x-custom-components.label>Customer Name</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.customerName" />
                    @error('item.customerName') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-custom-components.label>Invoice Date</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="date" step="0.0001" wire:model="item.invoiceDate" />
                    @error('item.invoiceDate') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>

                <div class="mt-4">
                    <x-custom-components.label>Invoice Due Date</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="number" step="0.0001" wire:model="item.dueDate" />
                    @error('item.dueDate') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>
   
            <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-custom-components.label>Order Number</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" step="0.0001" wire:model="item.orderNumber" />
                    @error('item.orderNumber') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>

                <div class="mt-4">
                    <x-custom-components.label>Invoice Number</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" step="0.0001" wire:model="item.invoiceNumber" />
                    @error('item.invoiceNumber') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>

            <table class="w-full whitespace-no-wrap mt-4 shadow-2xl text-xs" wire:loading.class.delay="opacity-50">
            <thead>
                <tr class="text-left font-bold bg-blue-400">
                <td class="px-3 py-2" >
                    <div class="flex items-center">
                      
                    </div>
                </td>
                <td class="px-3 py-2" >Description</td>
                <td class="px-3 py-2" >Quantity</td>
                <td class="px-3 py-2" >Price</td>
                <td class="px-3 py-2" >Amount</td>
                </tr>
            </thead>
            <tbody class="divide-y divide-blue-400">
            @foreach($itemList as $index => $item)
                <tr class="hover:bg-blue-300 {{ ($loop->even ) ? "bg-blue-100" : ""}}">
                    <td class="px-3 py-2" >        <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.{{ $index }}.name" /></td>
                    <td class="px-3 py-2" > <x-custom-components.input class="block mt-1 w-full" type="text" wire:model="item.{{ $index }}.description" /></td>
                    <td class="px-3 py-2" > <x-custom-components.input class="block mt-1 w-full" type="number" wire:model.live="item.{{ $index }}.quantity" wire:keydown="calculateTotal" /></td>
                    <td class="px-3 py-2" >
                        
                    <x-custom-components.input class="block mt-1 w-full" type="number" wire:model.live="item.{{ $index }}.price" wire:keydown="calculateTotal"/>
                    </td>

                    <td class="px-3 py-2" >
                        <x-custom-components.input class="block mt-1 w-full" type="number" wire:model.live="item.{{ $index }}.amount" readonly  />
                        </td>
                        <td class="px-3 py-2" >
                        <div style="display: flex; justify-content: center; align-items: center; height: 15vh;">
        <button type="submit" wire:click="removeItem({{ $index }})" class="flex items-center text-blue-500">
    <x-custom-components.icon-delete class="mr-1" />
</button>
</div> </td>
               </tr>
            @endforeach
            </tbody>
           
        </table>
        <div style="display: flex; justify-content: center; align-items: center; height: 15vh;">
        <button type="submit" wire:click="addItem" class="flex items-center text-blue-500">
    <x-custom-components.icon-add class="mr-1" />
    <span>Add Item</span>
</button>
</div>


                                            <div class="grid grid-cols-2 gap-8">
                                            <div class="mt-4">
                    <x-custom-components.label></x-custom-components.label>
                         </div>
                         <div class="mt-4 flex items-center">
    <span>Total</span>
    <x-custom-components.input class="block ml-2 mt-1 w-full total-input" type="number" step="0.0001" wire:model.live="itemTotal" readonly/>
</div>




            </div>
        <div class="grid grid-cols-1 gap-8">
                <div class="mt-4">
                    <x-custom-components.label>Footer</x-custom-components.label>
                    <x-custom-components.input class="block mt-1 w-full" type="text" step="0.0001" wire:model="item.footer" />
                    @error('item.footer') <x-custom-components.error-message>{{$message}}</x-custom-components.error-message> @enderror
                </div>
            </div>
      
         <div class="flex justify-center items-center">
    <div class="grid grid-cols-1 gap-8">
        <div class="mt-4 text-center">
            <x-custom-components.button
                class="w-full" 
                mode="add"
                wire:loading.attr="disabled"
                wire:click="save()"
            >
                Generate Invoice
            </x-custom-components.button>
        </div>
    </div>
</div>


     
</div>
</div>
