<div class="h-full bg-gray-200 p-8">
<div class="mt-8 min-h-screen">
@livewire('livewire-toast')
    <div class="flex justify-between">
        <div class="text-2xl" >Cars</div>
        <button type="submit" wire:click="$dispatchTo('car.create', 'showCreateForm')" class="text-blue-500">
            <x-custom-components.icon-add />
        </button> 
    </div>

    <div class="mt-6">
        <div class="flex justify-between">
            <div class="flex">

            </div>
            <div class="flex">

                <x-custom-components.page-dropdown />
            </div>
        </div>
        <table class="w-full whitespace-no-wrap mt-4 shadow-2xl text-xs" wire:loading.class.delay="opacity-50">
            <thead>
                <tr class="text-left font-bold bg-blue-400">
                <td class="px-3 py-2" >
                    <div class="flex items-center">
                        <button wire:click="sortBy('id')">Id</button>
                        <x-custom-components.sort-icon sortField="id" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </div>
                </td>
                <td class="px-3 py-2" >Name</td>
                <td class="px-3 py-2" >Car Number</td>
                <td class="px-3 py-2" >Actions</td>
                </tr>
            </thead>
            <tbody class="divide-y divide-blue-400">
            @foreach($results as $result)
                <tr class="hover:bg-blue-300 {{ ($loop->even ) ? "bg-blue-100" : ""}}">
                    <td class="px-3 py-2" >{{ $result->id }}</td>
                    <td class="px-3 py-2" >{{ $result->name }}</td>
                    <td class="px-3 py-2" >{{ $result->car_number }}</td>
                    <td class="px-3 py-2" >
                        <button type="submit" wire:click="$dispatchTo('car.create', 'showEditForm', { car: {{ $result->id}} })" class="text-green-500">
                            <x-custom-components.icon-edit />
                        </button>
                        <button type="submit" wire:click="$dispatchTo('car.create', 'showDeleteForm', { car: {{ $result->id}} })" class="text-red-500">
                            <x-custom-components.icon-delete />
                        </button>
                    </td>
               </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $results->links() }}
    </div>
    
    @livewire('car.create')
</div>
</div>