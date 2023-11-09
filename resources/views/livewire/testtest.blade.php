<div>
<div class="bg-white rounded-lg px-8 py-6 my-16 overflow-x-scroll custom-scrollbar">
    <div class="flex justify-between">
        <div class="text-2xl">Users</div>
        <button type="submit" wire:click="$dispatchTo('testtest-child', 'showCreateForm');" class="text-blue-500">
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
                <tr class="text-left font-bold bg-blue-400">
                <td class="px-3 py-2" >
                    <div class="flex items-center">
                        <button wire:click="sortBy('id')">Id</button>
                        <x-tall-crud-sort-icon sortField="id" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </div>
                </td>
                <td class="px-3 py-2" >Name</td>
                <td class="px-3 py-2" >Email</td>
                <td class="px-3 py-2" >Branch Id</td>
                <td class="px-3 py-2" >Email Verified At</td>
                <td class="px-3 py-2" >Password</td>
                <td class="px-3 py-2" >Profile Picture</td>
                <td class="px-3 py-2" >Deleted At</td>
                <td class="px-3 py-2" >Remember Token</td>
                <td class="px-3 py-2" >Created At</td>
                <td class="px-3 py-2" >Updated At</td>
                <td class="px-3 py-2" >Actions</td>
                </tr>
            </thead>
            <tbody class="divide-y divide-blue-400">
            @foreach($results as $result)
                <tr class="hover:bg-blue-300 {{ ($loop->even ) ? "bg-blue-100" : ""}}">
                    <td class="px-3 py-2" >{{ $result->id }}</td>
                    <td class="px-3 py-2" >{{ $result->name }}</td>
                    <td class="px-3 py-2" >{{ $result->email }}</td>
                    <td class="px-3 py-2" >{{ $result->branch_id }}</td>
                    <td class="px-3 py-2" >{{ $result->email_verified_at }}</td>
                    <td class="px-3 py-2" >{{ $result->password }}</td>
                    <td class="px-3 py-2" >{{ $result->profile_picture }}</td>
                    <td class="px-3 py-2" >{{ $result->deleted_at }}</td>
                    <td class="px-3 py-2" >{{ $result->remember_token }}</td>
                    <td class="px-3 py-2" >{{ $result->created_at }}</td>
                    <td class="px-3 py-2" >{{ $result->updated_at }}</td>
                    <td class="px-3 py-2" >
                        <button type="submit" wire:click="$dispatchTo('testtest-child', 'showEditForm', { user: {{ $result->id}} });" class="text-green-500">
                            <x-tall-crud-icon-edit />
                        </button>
                        <button type="submit" wire:click="$dispatchTo('testtest-child', 'showDeleteForm', { user: {{ $result->id}} });" class="text-red-500">
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
    @livewire('testtest-child')
    @livewire('livewire-toast')
</div>
 </div>