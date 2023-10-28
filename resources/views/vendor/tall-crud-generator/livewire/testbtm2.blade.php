
<x-tall-crud-accordion-header tab="3" x-if="addFeature | editFeature">
        Belongs To Many
        <x-slot name="help">
            Display BelongsToMany Relation Field in Add and Edit Form
        </x-slot>
    </x-tall-crud-accordion-header>

<x-tall-crud-dialog-modal wire:model.live="confirmingBelongsToMany" x-if="addFeature | editFeature">
<x-slot name="title">
    Add a Belongs to Many Relationship
</x-slot>

<x-slot name="content">
    <div class="mt-4">
        <div>
            <x-tall-crud-label>Select Relationship</x-tall-crud-label>
            <x-tall-crud-select class="block mt-1 w-1/2" wire:model.lazy="belongsToManyRelation.name">
                <option value="">-Please Select-</option>
                <template x-if="allRelations.contains('belongsToMany')" x-for="column in allRelations">
                    <option x-bind:value="column.name" x-text="column.name"></option>
             </template>
            </x-tall-crud-select>
            @error('belongsToManyRelation.name') <x-tall-crud-error-message>{{$message}}
            </x-tall-crud-error-message> @enderror
        </div>

      
        <div class="mt-4 p-4 rounded border border-gray-300" x-if="isValidbelongsToManyRelation">
       
                <x-tall-crud-label class="mt-2" x-if="addFeature">
                    Show in Add Form:
                    <x-tall-crud-checkbox class="ml-2" wire:model="belongsToManyRelation.inAdd" />
                </x-tall-crud-label>
   
                <x-tall-crud-label class="mt-2" x-if="editFeature">
                    Show in Edit Form:
                    <x-tall-crud-checkbox class="ml-2" wire:model="belongsToManyRelation.inEdit" />
                </x-tall-crud-label>
    
            <x-tall-crud-label class="mt-2">
                Display as Multi-Select (Default is Checkboxes):
                <x-tall-crud-checkbox class="ml-2" wire:model="belongsToManyRelation.isMultiSelect" />
            </x-tall-crud-label>

            <div class="mt-4">
                <x-tall-crud-label>Display Column</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-1/2"
                    wire:model="belongsToManyRelation.displayColumn">
                    <option value="">-Please Select-</option>
                    <template x-if="belongsToManyRelationColumns.contains(column)" x-for="column in belongsToManyRelationColumns">
                    <option x-bind:value="column" x-text="column"></option>
             </template>
                </x-tall-crud-select>
                @error('belongsToManyRelation.displayColumn') <x-tall-crud-error-message>{{$message}}
                </x-tall-crud-error-message> @enderror
            </div>
        </div>
   
    </div>
</x-slot>

<x-slot name="footer">
    <x-tall-crud-button wire:click="$set('confirmingBelongsToMany', false)">Cancel
    </x-tall-crud-button>
    <x-tall-crud-button mode="add" wire:click="addBelongsToManyRelation()">Save
    </x-tall-crud-button>
</x-slot>
</x-tall-crud-dialog-modal>


    

    <x-tall-crud-accordion-wrapper ref="advancedTab3" tab="3">
        <x-tall-crud-show-relations-table type="belongsToManyRelations"></x-tall-crud-show-relations-table>
    </x-tall-crud-accordion-wrapper>
  
