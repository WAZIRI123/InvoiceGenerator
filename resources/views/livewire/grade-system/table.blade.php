<div>
<div class="bg-white rounded-lg px-8 py-6 my-16 overflow-x-scroll custom-scrollbar">
@livewire('livewire-toast')
    <div class="flex justify-between">
        <div class="text-2xl">Grade_Systems</div>
        <button type="submit" wire:click="$dispatchTo('grade-system.create', 'showCreateForm');" class="text-blue-500">
            <x-tall-crud-icon-add />
        </button> 
    </div>

    <div class="mt-6">
        <div class="flex justify-between">
            <div class="flex">

            </div>
            <div class="flex">

                <x-tall-crud-page-dropdown />
            </div>
        </div>
        <table class="w-full my-8 whitespace-nowrap" wire:loading.class.delay="opacity-50">
            <thead class="bg-secondary text-gray-100 font-bold">
                <tr class="text-left font-bold bg-black-400">
                <td class="px-3 py-2" >
                    <div class="flex items-center">
                        <button wire:click="sortBy('id')">Id</button>
                        <x-tall-crud-sort-icon sortField="id" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </div>
                </td>
               
                <td class="px-3 py-2" >Mark From</td>
                <td class="px-3 py-2" >Mark To</td>
                <td class="px-3 py-2" >Remark</td>
                <td class="px-3 py-2" >Exam</td>
                <td class="px-3 py-2" >Actions</td>
                </tr>
            </thead>
            <tbody class="divide-y divide-blue-400">
            @foreach($results as $result)
                <tr class="hover:bg-blue-300 {{ ($loop->even ) ? "bg-blue-100" : ""}}">
                    <td class="px-3 py-2" >{{ $result->id }}</td>
                    <td class="px-3 py-2" >{{ $result->mark_from }}</td>
                    <td class="px-3 py-2" >{{ $result->mark_to }}</td>
                    <td class="px-3 py-2" >{{ $result->remark }}</td>
                    <td class="px-3 py-2" >{{ $result->exam?->name }}</td>
                    <td class="px-3 py-2" >
                        <button type="submit" wire:click="$dispatchTo('grade-system.create', 'showEditForm', { gradesystem: {{ $result->id}} });" class="text-green-500">
                            <x-tall-crud-icon-edit />
                        </button>
                        <button type="submit" wire:click="$dispatchTo('grade-system.create', 'showDeleteForm', { gradesystem: {{ $result->id}} });" class="text-red-500">
                            <x-tall-crud-icon-delete />
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
    @livewire('grade-system.create')
   
</div>
 </div>