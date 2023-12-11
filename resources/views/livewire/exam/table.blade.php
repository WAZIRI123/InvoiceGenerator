<div>
    
<div class="bg-white rounded-lg px-8 py-6 my-16 overflow-x-scroll custom-scrollbar">
    <div class="flex justify-between">
        <div class="text-2xl">Exams</div>
        <button type="submit" wire:click="$dispatchTo('exam.create', 'showCreateForm');" class="text-blue-500">
            <x-tall-crud-icon-add />
        </button> 
    </div>

    <div class="mt-6">
    @livewire('livewire-toast')
        <div class="flex justify-between">
            <div class="flex">
                <x-tall-crud-input-search />
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
                <td class="px-3 py-2" >Name</td>
                <td class="px-3 py-2" >Class</td>
                <td class="px-3 py-2" >marks distribution types</td>
                <td class="px-3 py-2" >open for marks entry</td>
                <td class="px-3 py-2" >Actions</td>
                </tr>
            </thead>
            <tbody class="divide-y divide-blue-400">
            @foreach($results as $result)
                <tr class="hover:bg-blue-300 {{ ($loop->even ) ? "bg-blue-100" : ""}}">
                    <td class="px-3 py-2" >{{ $result?->id }}</td>
                    <td class="px-3 py-2" >{{ $result?->name }}</td>
                    <td class="px-3 py-2" >{{ $result->class?->name }}</td>
                    <td class="px-3 py-2" >{{ \AppHelper::MARKS_DISTRIBUTION_TYPES[$result?->marks_distribution_types] }}</td>
 
                    <td class="px-3 py-2" >{{ $result?->open_for_marks_entry ? 'Yes':'No' }}</td>
                    <td class="px-3 py-2" >
                        <button type="submit" wire:click="$dispatchTo('exam.create', 'showEditForm', { exam: {{ $result?->id}} });" class="text-green-500">
                            <x-tall-crud-icon-edit />
                        </button>
                        <button type="submit" wire:click="$dispatchTo('exam.create', 'showDeleteForm', { exam: {{ $result?->id}} });" class="text-red-500">
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
    @livewire('exam.create')
  
</div>
 </div>