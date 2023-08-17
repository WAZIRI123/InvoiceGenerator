<div class="h-full bg-gray-200 p-8">
    <div class="mt-8 min-h-screen">
        @livewire('livewire-toast')
        <div class="flex justify-between">
           
            <div class="mt-4">
                <x-custom-components.button mode="add" wire:loading.attr="disabled" wire:click="print">Pdf</x-tall-crud-button>
                <x-custom-components.button mode="edit" wire:loading.attr="disabled" wire:click="export">Excel</x-tall-crud-button>
            </div>
           
            <button type="submit" wire:click="$dispatchTo('care-rental.create', 'showCreateForm')" class="text-blue-500">
                <x-custom-components.icon-add />
            </button>
            
        </div>

        <div class="mt-6">
            <div class="flex justify-between">
                <div class="flex">
                    <!-- Add filters or other components related to visitors -->
                </div>
                <div class="flex">
                    <x-custom-components.page-dropdown />
                </div>
            </div>
            <table class="w-full whitespace-no-wrap mt-4 shadow-2xl text-xs" wire:loading.class.delay="opacity-50">
                <thead>
                    <tr class="text-left font-bold bg-blue-400">
                        <td class="px-3 py-2">
                            <div class="flex items-center">
                                <button wire:click="sortBy('id')">Id</button>
                                <x-custom-components.sort-icon sortField="id" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                            </div>
                        </td>
                        <td class="px-3 py-2">Visitor Name</td>
                        <td class="px-3 py-2">Arrival Date</td>
                        <td class="px-3 py-2">Safari Start Date</td>
                        <td class="px-3 py-2">Safari End Date</td>
                        <td class="px-3 py-2">Car Number</td>
                        <td class="px-3 py-2">Guide Name</td>
                        <td class="px-3 py-2">Special Event</td>
                        <td class="px-3 py-2">Actions</td>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-400">
                    @foreach($results as $result)
                    <tr class="hover:bg-blue-300 {{ ($loop->even ) ? "bg-blue-100" : ""}}">
                        <td class="px-3 py-2">{{ $result->id }}</td>
                        <td class="px-3 py-2">{{ $result->visitorName }}</td>
                        <td class="px-3 py-2">{{ $result->arrivalDate }}</td>
                        <td class="px-3 py-2">{{ $result->safariStartDate }}</td>
                        <td class="px-3 py-2">{{ $result->safariEndDate }}</td>
                        <td class="px-3 py-2">{{ $result->carNumber }}</td>
                        <td class="px-3 py-2">{{ $result->guideName }}</td>
                        <td class="px-3 py-2">{{ $result->specialEvent }}</td>
                        <td class="px-3 py-2">
                            <button type="submit"
                                wire:click="$dispatchTo('care-rental.create', 'showEditForm', { rental: {{ $result->id }} })"
                                class="text-green-500">
                                <x-custom-components.icon-edit />
                            </button>
                            <button type="submit"
                                wire:click="$dispatchTo('care-rental.create', 'showDeleteForm', { rental: {{ $result->id }} })"
                                class="text-red-500">
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

        @livewire('care-rental.create')
    </div>
</div>
