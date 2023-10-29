
@if ($this->addFeature || $this->editFeature)
<x-tall-crud-dialog-modal wire:model.live="confirmingBelongsToMany">
    <x-slot name="title">
        Add a Belongs to Many Relationship
    </x-slot>

    <x-slot name="content">
        <div class="mt-4">
            <div>
                <x-tall-crud-label>Select Relationship</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-1/2" wire:model.live="belongsToManyRelation.name">
                    <option value="">-Please Select-</option>
                    @if (Arr::exists($allRelations, 'belongsToMany'))
                    @foreach ($allRelations['belongsToMany'] as $c)
                    <option value="{{$c['name']}}">{{$c['name']}}</option>
                    @endforeach
                    @endif
                </x-tall-crud-select>
                <x-tall-crud-error-message x-text="nameBtm == '' ? 'Please select a Relation' : belongsToManyRelations.find(r => r.relationName == nameBtm) ? 'Relation Already Defined.' : ''">
</x-tall-crud-error-message>
            </div>

            <div class="mt-4 p-4 rounded border border-gray-300"
            x-show="isValidbelongsToManyRelation">
                @if ($this->addFeature)
                    <x-tall-crud-label class="mt-2">
                        Show in Add Form:
                        <x-tall-crud-checkbox class="ml-2" wire:model="belongsToManyRelation.inAdd" />
                    </x-tall-crud-label>
                @endif
                @if ($this->editFeature)
                    <x-tall-crud-label class="mt-2">
                        Show in Edit Form:
                        <x-tall-crud-checkbox class="ml-2" wire:model="belongsToManyRelation.inEdit" />
                    </x-tall-crud-label>
                @endif
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
               
             <x-tall-crud-error-message  x-text="nameBtmDisplayColumn == '' ? ' displayColumn required '  : ''">
                </x-tall-crud-error-message> 
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
@endif

@if ($this->addFeature || $this->editFeature)
        <x-tall-crud-accordion-header tab="3">
            Belongs To Many
            <x-slot name="help">
                Display BelongsToMany Relation Field in Add and Edit Form
            </x-slot>
        </x-tall-crud-accordion-header>

        <x-tall-crud-accordion-wrapper ref="advancedTab3" tab="3">
            <x-tall-crud-show-relations-table type="belongsToManyRelations"></x-tall-crud-show-relations-table>
        </x-tall-crud-accordion-wrapper>
        @endif
