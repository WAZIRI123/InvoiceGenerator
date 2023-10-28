   
    <x-tall-crud-dialog-modal wire:model.live="confirmingWithCount">
<x-slot name="title">
    Eager Load Count
</x-slot>

<x-slot name="content">
    <div class="mt-4">
        <div>
            <x-tall-crud-label>Select Relationship</x-tall-crud-label>
            <x-tall-crud-select class="block mt-1 w-1/2" wire:model.lazy="withCountRelation.name">
                <option value="">-Please Select-</option>
                @foreach ($allRelations as $allRelation)
                @foreach ($allRelation as $c)
                <option value="{{$c['name']}}">{{$c['name']}}</option>
                @endforeach
                @endforeach
            </x-tall-crud-select>
            @error('withCountRelation.name') <x-tall-crud-error-message>{{$message}}
            </x-tall-crud-error-message> @enderror
        </div>

       
            <x-tall-crud-label class="mt-2" x-show="isvalidWithCountRelation">
                Make Heading Sortable
                <x-tall-crud-checkbox class="ml-2" wire:model="withCountRelation.isSortable" />
            </x-tall-crud-label>
    
    </div>
</x-slot>

<x-slot name="footer">
    <x-tall-crud-button wire:click="$set('confirmingWithCount', false)">Cancel
    </x-tall-crud-button>
    <x-tall-crud-button mode="add" wire:click="addWithCountRelation()">Save
    </x-tall-crud-button>
</x-slot>
</x-tall-crud-dialog-modal>

    
    <x-tall-crud-accordion-header tab="2">
        Eager Load Count
        <x-slot name="help">
            Eager Load Count of a Related Model to display in Listing
        </x-slot>
    </x-tall-crud-accordion-header>

    <x-tall-crud-accordion-wrapper ref="advancedTab2" tab="2">
        <x-tall-crud-button class="mt-4" wire:click="createNewWithCountRelation">Add
        </x-tall-crud-button>
        <x-tall-crud-table class="mt-4">
            <x-slot name="header">
                <x-tall-crud-table-column>Relation</x-tall-crud-table-column>
                <x-tall-crud-table-column>Sortable</x-tall-crud-table-column>
                <x-tall-crud-table-column>Actions</x-tall-crud-table-column>
            </x-slot>
            <template  x-for="(withCountRelation,i) in withCountRelations" :key="i">
            <tr>
                <x-tall-crud-table-column x-text="withCountRelation.relationName"></x-tall-crud-table-column>
                <x-tall-crud-table-column x-text="withCountRelation.isSortable? 'Yes': 'No'">
                </x-tall-crud-table-column>
                <x-tall-crud-table-column>
                    <x-tall-crud-button wire:click.prevent="deleteWithCountRelation($i)"
                        mode="delete">
                        Delete
                    </x-tall-crud-button>
                </x-tall-crud-table-column>
            </tr>
            </template>
        </x-tall-crud-table>
    </x-tall-crud-accordion-wrapper>