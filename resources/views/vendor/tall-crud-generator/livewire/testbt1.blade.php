
@if ($this->addFeature || $this->editFeature)

<x-tall-crud-dialog-modal wire:model.live="confirmingBelongsTo">
<x-slot name="title">
    Add a Belongs to Relationship
</x-slot>

<x-slot name="content">
    <div class="mt-4">
        <div>
            <x-tall-crud-label>Select Relationship</x-tall-crud-label>
            <x-tall-crud-select class="block mt-1 w-1/2" wire:model.lazy="belongsToRelation.name">
                <option value="">-Please Select-</option>
                @if (Arr::exists($allRelations, 'belongsTo'))
                @foreach ($allRelations['belongsTo'] as $c)
                <option value="{{$c['name']}}">{{$c['name']}}</option>
                @endforeach
                @endif
                
            </x-tall-crud-select>
            <h1 ></h1>
            @error('belongsToRelation.name') <x-tall-crud-error-message>{{$message}}
            </x-tall-crud-error-message> @enderror

        </div>

        <div class="mt-4 p-4 rounded border border-gray-300" x-show="isValidbelongsToRelation">
        @if ($this->addFeature)
                <x-tall-crud-label class="mt-2">
                    Show in Add Form: 
                    <x-tall-crud-checkbox class="ml-2" wire:model="belongsToRelation.inAdd" />
                </x-tall-crud-label>

   @endif
   @if ($this->editFeature)
                <x-tall-crud-label class="mt-2">
                    Show in Edit Form:
                    <x-tall-crud-checkbox class="ml-2" wire:model="belongsToRelation.inEdit" />
                </x-tall-crud-label>
                @endif

            <div class="mt-4">
                <x-tall-crud-label>Display Column</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-1/4"
                    wire:model="belongsToRelation.displayColumn">
                    <option value="">-Please Select-</option>
  <template x-for="column in belongsToRelationColumns">
                    <option x-bind:value="column" x-text="column"></option>
             </template>
                  
                </x-tall-crud-select>
                @error('belongsToRelation.displayColumn') <x-tall-crud-error-message>{{$message}}
                </x-tall-crud-error-message> @enderror
            </div>
        </div>
      
    </div>
</x-slot>

<x-slot name="footer">
    <x-tall-crud-button wire:click="$set('confirmingBelongsTo', false)">Cancel
    </x-tall-crud-button>
    <x-tall-crud-button mode="add" wire:click="addBelongsToRelation()">Save
    </x-tall-crud-button>
</x-slot>
</x-tall-crud-dialog-modal>
@endif


    @if ($this->addFeature || $this->editFeature)
    <x-tall-crud-accordion-header tab="4">
        Belongs To
        <x-slot name="help">
            <h1 x-text=""></h1>
      
            Display BelongsTo Relation Field in Add and Edit Form
        </x-slot>
    </x-tall-crud-accordion-header>

    <x-tall-crud-accordion-wrapper ref="advancedTab4" tab="4">
        <x-tall-crud-show-relations-table type="belongsToRelations"></x-tall-crud-show-relations-table>
    </x-tall-crud-accordion-wrapper>
    @endif
