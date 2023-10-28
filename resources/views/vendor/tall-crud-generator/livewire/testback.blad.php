<div>
    @php
    $wizardHeadings = [
    '1' => 'Select Model',
    '2' => 'Select Features',
    '3' => 'Select Fields',
    '4' => 'Relations',
    '5' => 'Sort Fields',
    '6' => 'Advanced',
    '7' => 'Generate Files',
    ];
    @endphp


    <div class="h-32 grid grid-rows-1 grid-flow-col gap-0">
        @for ($i = 1; $i <= $totalSteps; $i++) <x-tall-crud-wizard-step :active="$i <= $step"
            :current="$i == $step" :isLast="$i == $totalSteps">
            {{$i}}
            <x-slot name="content">
                {{$wizardHeadings[$i]}}
            </x-slot>
            </x-tall-crud-wizard-step>
            @endfor
    </div>

    <x-tall-crud-h2 class="border-b-2 border-gray-300 text-2xl">{{$wizardHeadings[$step]}}
    </x-tall-crud-h2>

    <div class="border-b-2 border-gray-300 py-4 px-6">
        @switch($step)
            @case(1)
            <div>
    <x-tall-crud-label>Full Path to Your Model (e.g. App\Models\Product)</x-tall-crud-label>
    <x-tall-crud-input class="block mt-1 w-1/4" type="text" wire:model="modelPath" required
        disabled="{{$isValidModel}}" />
    @error('modelPath') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message>
    @enderror
</div>
                @break

                @case(2)
                <div>

<div  x-data="{showPrimaryKeyInListing : @entangle('primaryKeyProps.inList') }">
    <div class="text-black bg-gray-200 p-4">Table Name is: <span class="font-bold">
            {{$modelProps['tableName']}}</span></div>
    <div class="text-black bg-gray-200 p-4 mt-2">Primary Key is: <span class="font-bold">
            {{$modelProps['primaryKey']}}</span></div>

    <x-tall-crud-h2>Primary Key Features</x-tall-crud-h2>
    <x-tall-crud-label class="mt-2">
        Display In Listing:
        <x-tall-crud-checkbox class="ml-2" wire:model="primaryKeyProps.inList"
            @click="showPrimaryKeyInListing = ! showPrimaryKeyInListing " />
    </x-tall-crud-label>

    <x-tall-crud-label class="mt-2" x-show="showPrimaryKeyInListing">
        Sortable:
        <x-tall-crud-checkbox class="ml-2" wire:model="primaryKeyProps.sortable" />
    </x-tall-crud-label>

    <div x-show="showPrimaryKeyInListing">
        <x-tall-crud-label class="mt-2">Label:</x-tall-crud-label>
        <x-tall-crud-input type="text" class="mt-1 block w-1/4" wire:model="primaryKeyProps.label"
            placeholder="Label" />
    </div>

    <x-tall-crud-h2>Select Modal</x-tall-crud-h2>

    <x-tall-crud-label class="mt-2">
        Add Modal
        <x-tall-crud-checkbox class="ml-2" wire:model="componentProps.createAddModal" />
    </x-tall-crud-label>

    <x-tall-crud-label class="mt-2">
        Edit Modal
        <x-tall-crud-checkbox class="ml-2" wire:model="componentProps.createEditModal" />
    </x-tall-crud-label>

    <x-tall-crud-label class="mt-2">
        Delete Modal
        <x-tall-crud-checkbox class="ml-2" wire:model="componentProps.createDeleteButton" />
    </x-tall-crud-label>
</div>
</div>
                @break



                @case(3)
                @if(count($fields) == 0)
<x-tall-crud-button wire:click.prevent="addAllFields">
    Add All Fields
</x-tall-crud-button>
@endif

<x-tall-crud-table class="mt-4">
    <x-slot name="header">
        <x-tall-crud-table-column>Column</x-tall-crud-table-column>
        <x-tall-crud-table-column>Label</x-tall-crud-table-column>
        @if (!$this->addAndEditDisabled)
        <x-tall-crud-table-column>Display In Listing</x-tall-crud-table-column>
        @endif
        @if ($this->addFeature)
        <x-tall-crud-table-column>Display In Create</x-tall-crud-table-column>
        @endif
        @if ($this->editFeature)
        <x-tall-crud-table-column>Display In Edit</x-tall-crud-table-column>
        @endif
        <x-tall-crud-table-column>Searchable</x-tall-crud-table-column>
        <x-tall-crud-table-column>Sortable</x-tall-crud-table-column>
        <x-tall-crud-table-column>Actions</x-tall-crud-table-column>
    </x-slot>
    @foreach ($fields as $i => $field)
    <tr>
        <x-tall-crud-table-column>
            <select wire:model="fields.{{$i}}.column" class="form-select rounded-md shadow-sm">
                <option value="">-Select Column-</option>
                @if (Arr::exists($this->modelProps, 'columns'))
                @foreach ($this->modelProps['columns'] as $column)
                <option value="{{$column}}">{{$column}}</option>
                @endforeach
                @endif
            </select>
        </x-tall-crud-table-column>
        <x-tall-crud-table-column>
            <x-tall-crud-input type="text" class="mt-1 block w-full" wire:model="fields.{{$i}}.label"
                placeholder="Label" />
        </x-tall-crud-table-column>
        @if (!$this->addAndEditDisabled)
        <x-tall-crud-table-column>
            <x-tall-crud-checkbox wire:model="fields.{{$i}}.inList" />
        </x-tall-crud-table-column>
        @endif
        @if ($this->addFeature)
        <x-tall-crud-table-column>
            <x-tall-crud-checkbox wire:model="fields.{{$i}}.inAdd" />
        </x-tall-crud-table-column>
        @endif
        @if ($this->editFeature)
        <x-tall-crud-table-column>
            <x-tall-crud-checkbox wire:model="fields.{{$i}}.inEdit" />
        </x-tall-crud-table-column>
        @endif
        <x-tall-crud-table-column>
            <x-tall-crud-checkbox wire:model="fields.{{$i}}.searchable" />
        </x-tall-crud-table-column>
        <x-tall-crud-table-column>
            <x-tall-crud-checkbox wire:model="fields.{{$i}}.sortable" />
        </x-tall-crud-table-column>
        <x-tall-crud-table-column>
            @if (!$this->addAndEditDisabled)
            <x-tall-crud-button wire:click.prevent="showFieldAttributes({{$i}})" mode="edit" class="mr-8 mt-4">
                Attributes
            </x-tall-crud-button>
            @endif
            <x-tall-crud-button wire:click.prevent="deleteField({{$i}})" mode="delete" class="mr-8 mt-4">
                Delete
            </x-tall-crud-button>
        </x-tall-crud-table-column>
    </tr>
    @endforeach
</x-tall-crud-table>

<div class="mt-4">
    <x-tall-crud-button mode="add" wire:click.prevent="addField">
        Add New Field
    </x-tall-crud-button>
    @error('fields') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
</div>

@if (!$this->addAndEditDisabled)
<x-tall-crud-dialog-modal wire:model.live="confirmingFieldAttributes">
    <x-slot name="title">
        Attributes
    </x-slot>

    <x-slot name="content">
        <div class="mt-4">
            <div>
                <x-tall-crud-label>Enter Validations (Comma separated)
                    <x-tall-crud-tag wire:click="clearRules()">Clear Options</x-tall-crud-tag>
                </x-tall-crud-label>
                <x-tall-crud-input wire:model="fieldAttributes.rules" class="block mt-1 w-full"
                    type="text" />

                Popular Validations:
                <x-tall-crud-tag wire:click="addRule('required')">Required</x-tall-crud-tag>
                <x-tall-crud-tag wire:click="addRule('min:3')">Min</x-tall-crud-tag>
                <x-tall-crud-tag wire:click="addRule('max:50')">Max</x-tall-crud-tag>
                <x-tall-crud-tag wire:click="addRule('numeric')">Numeric</x-tall-crud-tag>
            </div>

            <div class="mt-4">
                <x-tall-crud-label>Field Type</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-1/4" wire:model.live="fieldAttributes.type">
                    <option value="input">Input</option>
                    <option value="select">Select</option>
                    <option value="checkbox">Checkbox</option>
                </x-tall-crud-select>
            </div>

            @if ($fieldAttributes['type'] == 'select')
            <x-tall-crud-label>Select Options (add as JSON)</x-tall-crud-label>
            <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="fieldAttributes.options" />
            @endif
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-tall-crud-button wire:click="$set('confirmingFieldAttributes', false)">Cancel
        </x-tall-crud-button>
        <x-tall-crud-button mode="add" wire:click="setFieldAttributes()">Save</x-tall-crud-button>
    </x-slot>
</x-tall-crud-dialog-modal>
@endif
                @break


                @case(4)
                <div wire:ignore x-data="{ selected : @entangle('selected').live, isvalidWithRelation: @entangle('withRelation.isValid').live,columns: @entangle('withRelation.columns').live, displayColumn: @entangle('withRelation.displayColumn').live,message: @entangle('message').live}">

<div  >

<x-tall-crud-dialog-modal wire:model.live="confirmingWith">
<x-slot name="title">
    Eager Load a Relationship
</x-slot>

<x-slot name="content">
    <div class="mt-4">
        <div>
            <x-tall-crud-label>Select Relationship</x-tall-crud-label>
            <x-tall-crud-select class="block mt-1 w-1/2" wire:model.lazy="withRelation.name">
                <option value="">-Please Select-</option>
                @foreach ($allRelations as $allRelation)
                @foreach ($allRelation as $c)
                <option value="{{$c['name']}}">{{$c['name']}}</option>
                @endforeach
                @endforeach
            </x-tall-crud-select>
            @error('withRelation.name') <x-tall-crud-error-message>{{$message}}
            </x-tall-crud-error-message> @enderror
        </div>

     
        <div class="mt-4 p-4 rounded border border-gray-300" x-show="isvalidWithRelation">
            <div class="mt-4">
                <x-tall-crud-label>Display Column</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-1/2"
                    wire:model="withRelation.displayColumn">
                    <option value="">-Please Select-</option>

                    <template x-if="columns.includes(column)" x-for="column in columns">
                    <option value="column" x-text="column"></option>
             </template>
                </x-tall-crud-select>
            <h1 x-text="message"></h1>
            </div>
        </div>
    
        
    </div>
</x-slot>

<x-slot name="footer">
    <x-tall-crud-button wire:click="$set('confirmingWith', false)">Cancel</x-tall-crud-button>
    <x-tall-crud-button mode="add" wire:click="addWithRelation()">Save</x-tall-crud-button>
</x-slot>
</x-tall-crud-dialog-modal>



    <x-tall-crud-accordion-header tab="1">
        Eager Load <h1 x-text="isvalidWithRelation"></h1>
        <x-slot name="help">
            Eager Load a Related Model to display in Listing
        </x-slot>
    </x-tall-crud-accordion-header>

    <x-tall-crud-accordion-wrapper   ref="advancedTab1" tab="1">
        <x-tall-crud-button class="mt-4" wire:click="createNewWithRelation">Add
        </x-tall-crud-button>
        <x-tall-crud-table class="mt-4">
            <x-slot name="header">
                <x-tall-crud-table-column>Relation</x-tall-crud-table-column>
                <x-tall-crud-table-column>Display Column</x-tall-crud-table-column>
                <x-tall-crud-table-column>Actions</x-tall-crud-table-column>
            </x-slot>
            @foreach ($this->withRelations as $i => $v)
            <tr>
                <x-tall-crud-table-column>{{$v['relationName']}}</x-tall-crud-table-column>
                <x-tall-crud-table-column>{{$v['displayColumn']}}</x-tall-crud-table-column>
                <x-tall-crud-table-column>
                    <x-tall-crud-button wire:click="deleteWithRelation({{$i}})" mode="delete">
                        Delete
                    </x-tall-crud-button>
                </x-tall-crud-table-column>
            </tr>
            @endforeach
        </x-tall-crud-table>
    </x-tall-crud-accordion-wrapper>

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
            @foreach ($this->withCountRelations as $i => $v)
            <tr>
                <x-tall-crud-table-column>{{$v['relationName']}}</x-tall-crud-table-column>
                <x-tall-crud-table-column>{{$v['isSortable'] ? 'Yes' : 'No'}}
                </x-tall-crud-table-column>
                <x-tall-crud-table-column>
                    <x-tall-crud-button wire:click.prevent="deleteWithCountRelation({{$i}})"
                        mode="delete">
                        Delete
                    </x-tall-crud-button>
                </x-tall-crud-table-column>
            </tr>
            @endforeach
        </x-tall-crud-table>
    </x-tall-crud-accordion-wrapper>

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

    @if ($this->addFeature || $this->editFeature)
    <x-tall-crud-accordion-header tab="4">
        Belongs To
        <x-slot name="help">
            Display BelongsTo Relation Field in Add and Edit Form
        </x-slot>
    </x-tall-crud-accordion-header>

    <x-tall-crud-accordion-wrapper ref="advancedTab4" tab="4">
        <x-tall-crud-show-relations-table type="belongsToRelations"></x-tall-crud-show-relations-table>
    </x-tall-crud-accordion-wrapper>
    @endif
</div>
</div>

@if ($this->addFeature || $this->editFeature)
<x-tall-crud-dialog-modal wire:model.live="confirmingBelongsToMany">
<x-slot name="title">
    Add a Belongs to Many Relationship
</x-slot>

<x-slot name="content">
    <div class="mt-4">
        <div>
            <x-tall-crud-label>Select Relationship</x-tall-crud-label>
            <x-tall-crud-select class="block mt-1 w-1/2" wire:model.lazy="belongsToManyRelation.name">
                <option value="">-Please Select-</option>
                @if (Arr::exists($allRelations, 'belongsToMany'))
                @foreach ($allRelations['belongsToMany'] as $c)
                <option value="{{$c['name']}}">{{$c['name']}}</option>
                @endforeach
                @endif
            </x-tall-crud-select>
            @error('belongsToManyRelation.name') <x-tall-crud-error-message>{{$message}}
            </x-tall-crud-error-message> @enderror
        </div>

        @if ($belongsToManyRelation['isValid'])
        <div class="mt-4 p-4 rounded border border-gray-300">
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
                    @if (Arr::exists($belongsToManyRelation, 'columns'))
                    @foreach ($belongsToManyRelation['columns'] as $c)
                    <option value="{{$c}}">{{$c}}</option>
                    @endforeach
                    @endif
                </x-tall-crud-select>
                @error('belongsToManyRelation.displayColumn') <x-tall-crud-error-message>{{$message}}
                </x-tall-crud-error-message> @enderror
            </div>
        </div>
        @endif
    </div>
</x-slot>

<x-slot name="footer">
    <x-tall-crud-button wire:click="$set('confirmingBelongsToMany', false)">Cancel
    </x-tall-crud-button>
    <x-tall-crud-button mode="add" wire:click="addBelongsToManyRelation()">Save
    </x-tall-crud-button>
</x-slot>
</x-tall-crud-dialog-modal>

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
            @error('belongsToRelation.name') <x-tall-crud-error-message>{{$message}}
            </x-tall-crud-error-message> @enderror
        </div>

        @if ($belongsToRelation['isValid'])
        <div class="mt-4 p-4 rounded border border-gray-300">
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
                    @if (Arr::exists($belongsToRelation, 'columns'))
                    @foreach ($belongsToRelation['columns'] as $c)
                    <option value="{{$c}}">{{$c}}</option>
                    @endforeach
                    @endif
                </x-tall-crud-select>
                @error('belongsToRelation.displayColumn') <x-tall-crud-error-message>{{$message}}
                </x-tall-crud-error-message> @enderror
            </div>
        </div>
        @endif
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

        @if ($withCountRelation['isValid'])
            <x-tall-crud-label class="mt-2">
                Make Heading Sortable
                <x-tall-crud-checkbox class="ml-2" wire:model="withCountRelation.isSortable" />
            </x-tall-crud-label>
        @endif
    </div>
</x-slot>

<x-slot name="footer">
    <x-tall-crud-button wire:click="$set('confirmingWithCount', false)">Cancel
    </x-tall-crud-button>
    <x-tall-crud-button mode="add" wire:click="addWithCountRelation()">Save
    </x-tall-crud-button>
</x-slot>
</x-tall-crud-dialog-modal>
                @break



                @case(5)
                <div>
    <ul>
        <li class="flex">
            <span class="cursor-pointer text-blue-500 font-medium" wire:click="showSortDialog('listing')">Listing</span>
            <x-tall-crud-tooltip>
                Change the Order of Columns displayed in the Listing
            </x-tall-crud-tooltip>
        </li>
        @if($this->addFeature)
        <li class="flex mt-4">
            <span class="cursor-pointer text-blue-500 font-medium" wire:click="showSortDialog('add')">Add Fields</span>
            <x-tall-crud-tooltip>
                Change the Order of Fields displayed in the Add Form
            </x-tall-crud-tooltip>
        </li>
        @endif
        @if($this->editFeature)
        <li class="flex mt-4">
            <span class="cursor-pointer text-blue-500 font-medium" wire:click="showSortDialog('edit')">Edit Fields</span>
            <x-tall-crud-tooltip>
                Change the Order of Fields displayed in the Edit Form
            </x-tall-crud-tooltip>
        </li>
        @endif
    </ul>
</div>

<x-tall-crud-dialog-modal wire:model.live="confirmingSorting">
    <x-slot name="title">
        Sort Fields
    </x-slot>

    <x-slot name="content">
        <ul drag-root class="overflow-hidden rounded shadow divide-y">
            @if(!empty($this->sortingMode))
            @foreach($this->sortFields[$this->sortingMode] as $t)
                <li drag-item="{{ (isset($t['type']) && $t['type'] == 'withCount') ?  $t['field'] . ' (Count)' : $t['field']}}" draggable="true" wire:key="{{$t['field']}}" class="w-64 p-4 bg-white border">
                    {{$t['field']}}
                    {{ (isset($t['type']) && $t['type'] == 'withCount') ? '(Count)' : ''}}
                </li>
            @endforeach
            @endif
        </ul>
    </x-slot>

    <x-slot name="footer">
        <x-tall-crud-button mode="add" wire:click="hideSortDialog()">Done</x-tall-crud-button>
    </x-slot>
</x-tall-crud-dialog-modal>

<script>
    window.addEventListener('init-sort-events', event => {
        let root = document.querySelector('[drag-root]')
        root.querySelectorAll('[drag-item]').forEach( el => {
            el.addEventListener('dragstart' , e => {
                e.target.setAttribute('dragging', true);
            })

            el.addEventListener('drop' , e => {
                e.target.classList.remove('bg-yellow-200')
                let draggingEl = root.querySelector('[dragging]')
                e.target.before(draggingEl);
                let component = window.Livewire.find(
                    e.target.closest('[wire\\:id]').getAttribute('wire:id')
                )

                let orderIds = Array.from(root.querySelectorAll('[drag-item]'))
                    .map(itemEl => itemEl.getAttribute('drag-item'))
                component.call('reorder', orderIds);
            })
            
            el.addEventListener('dragenter' , e => {
                e.target.classList.add('bg-yellow-200')
                e.preventDefault();
            })
            el.addEventListener('dragover' , e => e.preventDefault())
            el.addEventListener('dragleave' , e => {
                e.target.classList.remove('bg-yellow-200')
            })

            el.addEventListener('dragend' , e => {
                e.target.removeAttribute('dragging');
            })
        })
    })
</script>
        @break


                @case(6)
                
    <x-tall-crud-accordion-header tab="1">
        Customize Text
        <x-slot name="help">
            Customize the Text of Buttons, Links and Headings.
        </x-slot>
    </x-tall-crud-accordion-header>

    <x-tall-crud-accordion-wrapper ref="advancedTab1" tab="1">
        @foreach ($advancedSettings['text'] as $key => $text)
        <div class="mt-4">
            <x-tall-crud-label>
                {{ $this->getAdvancedSettingLabel($key)}}
            </x-tall-crud-label>
            <x-tall-crud-input class="block mt-1 w-1/4" type="text"
                wire:model="advancedSettings.text.{{$key}}" />
        </div>
        @endforeach
    </x-tall-crud-accordion-wrapper>

    <x-tall-crud-accordion-header tab="2">
        Flash Messages
        <x-slot name="help">
            Enable / Disable Flash Messages & Customize their Text.
        </x-slot>
    </x-tall-crud-accordion-header>

    <x-tall-crud-accordion-wrapper ref="advancedTab2" tab="2">
        <x-tall-crud-label class="mt-2">
            Enable Flash Messages:
            <x-tall-crud-checkbox class="ml-2" wire:model="flashMessages.enable" />
        </x-tall-crud-label>

        @foreach (['add', 'edit', 'delete'] as $key)
        <div class="mt-4">
            <x-tall-crud-label>{{ Str::title($key)}}:</x-tall-crud-label>
            <x-tall-crud-input type="text" class="mt-1 block w-1/2"
                wire:model="flashMessages.text.{{$key}}" />
        </div>
        @endforeach
    </x-tall-crud-accordion-wrapper>

    <x-tall-crud-accordion-header tab="3">
        Table Settings
        <x-slot name="help">
            Customize the Properties of Table displaying the Listing
        </x-slot>
    </x-tall-crud-accordion-header>
    <x-tall-crud-accordion-wrapper ref="advancedTab3" tab="3">
        <x-tall-crud-label class="mt-2">
            Show Pagination Dropdown:
            <x-tall-crud-checkbox class="ml-2" wire:model="advancedSettings.table_settings.showPaginationDropdown" />
        </x-tall-crud-label>
        <x-tall-crud-checkbox-wrapper class="mt-4">
            <x-tall-crud-label>Records Per Page: </x-tall-crud-label>
            <x-tall-crud-select class="block mt-1 w-1/6 ml-2"
                wire:model.live="advancedSettings.table_settings.recordsPerPage">
                @foreach ([10, 15, 20, 50] as $p)
                <option value="{{$p}}">{{$p}}</option>
                @endforeach
            </x-tall-crud-select>
        </x-tall-crud-checkbox-wrapper>
        <x-tall-crud-label class="mt-4">
            Allow User to Hide Column in Listing <span class="italic">(only works with Alpine v3):</span>
            <x-tall-crud-checkbox class="ml-2" wire:model="advancedSettings.table_settings.showHideColumns" />
        </x-tall-crud-label>
        <x-tall-crud-label class="mt-4">
            Enable Bulk Actions
            <x-tall-crud-checkbox class="ml-2" wire:model="advancedSettings.table_settings.bulkActions" />
        </x-tall-crud-label>
        @if($this->advancedSettings['table_settings']['bulkActions'])
        <x-tall-crud-checkbox-wrapper>
            <x-tall-crud-label>Column to Change on Bulk Action: </x-tall-crud-label>
            <x-tall-crud-select class="block mt-1 w-1/6 ml-2"
                wire:model.live="advancedSettings.table_settings.bulkActionColumn">
                <option value="">-Select Column-</option>
                @if (Arr::exists($modelProps, 'columns'))
                @foreach ($modelProps['columns'] as $column)
                <option value="{{$column}}">{{$column}}</option>
                @endforeach
                @endif
            </x-tall-crud-select>
        </x-tall-crud-checkbox-wrapper>
        @endif
        <div class="mt-4">The Table uses Blue Theme. You can change the theme by changing <span class="font-bold text-blue-700">blue</span> classes to other class. Check <a href="https://v2.tailwindcss.com/docs/customizing-colors" target="_blank" class="text-blue-300 cursor-pointer">v2</a> or <a class="text-blue-300 cursor-pointer" target="_blank" href="https://tailwindcss.com/docs/customizing-colors">v3</a> for other classes.</div>
        <div class="mt-4">
            <x-tall-crud-label>Class on th:</x-tall-crud-label>
            <x-tall-crud-input type="text" class="mt-1 block w-1/4"
                wire:model="advancedSettings.table_settings.classes.th" />
        </div>
        <div class="mt-4">
            <x-tall-crud-label>Hover Class on tr:</x-tall-crud-label>
            <x-tall-crud-input type="text" class="mt-1 block w-1/4"
                wire:model="advancedSettings.table_settings.classes.trHover" />
        </div>
        <div class="mt-4">
            <x-tall-crud-label>Even Row Class:</x-tall-crud-label>
            <x-tall-crud-input type="text" class="mt-1 block w-1/4"
                wire:model="advancedSettings.table_settings.classes.trEven" />
        </div>
        <div class="mt-4">
            <x-tall-crud-label>Table Row Divide Class:</x-tall-crud-label>
            <x-tall-crud-input type="text" class="mt-1 block w-1/4"
                wire:model="advancedSettings.table_settings.classes.trBottomBorder" />
        </div>
        <div class="mt-4">
            <x-tall-crud-label>Class on td:</x-tall-crud-label>
            <x-tall-crud-input type="text" class="mt-1 block w-1/4"
                wire:model="advancedSettings.table_settings.classes.td" />
        </div>
    </x-tall-crud-accordion-wrapper>
    <x-tall-crud-accordion-header tab="4">
        Filters
        <x-slot name="help">
            Define Filters so that Users can Search throuth the data from your Listing
        </x-slot>
    </x-tall-crud-accordion-header>

    <x-tall-crud-accordion-wrapper ref="advancedTab4" tab="4">
        <x-tall-crud-button class="mt-4" wire:click="createNewFilter">Add
        </x-tall-crud-button>
        <x-tall-crud-table class="mt-4">
            <x-slot name="header">
                <x-tall-crud-table-column>Type</x-tall-crud-table-column>
                <x-tall-crud-table-column>Column</x-tall-crud-table-column>
                <x-tall-crud-table-column>Actions</x-tall-crud-table-column>
            </x-slot>
            @foreach ($this->filters as $i => $v)
            <tr>
                <x-tall-crud-table-column>{{$v['type']}}</x-tall-crud-table-column>
                <x-tall-crud-table-column>
                     @if($v['type'] == 'None' || $v['type'] == 'Date' )
                        @if($v['type'] == 'Date')
                            {{ $v['operator'] }} 
                        @endif
                        {{$v['column']}}
                     @elseif($v['type'] == 'BelongsTo' || $v['type'] == 'BelongsToMany')
                        {{$v['relation']. '.' . $v['column']}}
                     @endif
                </x-tall-crud-table-column>
                <x-tall-crud-table-column>
                    <x-tall-crud-button wire:click.prevent="deleteFilter({{$i}})" mode="delete">
                        Delete
                    </x-tall-crud-button>
                </x-tall-crud-table-column>
            </tr>
            @endforeach
        </x-tall-crud-table>
    </x-tall-crud-accordion-wrapper>
</div>
</div>

<x-tall-crud-dialog-modal wire:model.live="confirmingFilter">
<x-slot name="title">
    Add a New Filter
</x-slot>

<x-slot name="content">
    <div class="mt-4">
        <div>
            <x-tall-crud-label>Select Type</x-tall-crud-label>
            <x-tall-crud-select class="block mt-1 w-1/2" wire:model.lazy="filter.type">
                <option value="">-Please Select-</option>
                <option value="None">None</option>
                <option value="BelongsTo">Belongs To</option>
                <option value="BelongsToMany">Belongs To Many</option>
                <option value="Date">Date Filter</option>
            </x-tall-crud-select>
            @error('filter.type') <x-tall-crud-error-message>{{$message}}
            </x-tall-crud-error-message> @enderror
        </div>

        @if ($filter['isValid'])
        <div class="mt-4 p-4 rounded border border-gray-300">
            @if ( $filter['type'] == 'None' || $filter['type'] == 'Date')
            <div class="mt-4">
                <x-tall-crud-label>
                    Column
                </x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-1/2"
                    wire:model.lazy="filter.column">
                    <option value="">-Please Select-</option>
                    @if (Arr::exists($filter, 'columns'))
                    @foreach ($filter['columns'] as $c)
                    <option value="{{$c}}">{{$c}}</option>
                    @endforeach
                    @endif
                </x-tall-crud-select>
                @error('filter.column') <x-tall-crud-error-message>{{$message}}
                </x-tall-crud-error-message> @enderror
            </div>
            @endif

            @if ( $filter['type'] == 'Date')
            <div class="mt-4">
                <x-tall-crud-label>Label</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-1/2" type="text" wire:model="filter.label" />
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Operator</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-1/6" wire:model.lazy="filter.operator">
                    <option value=">=">>=</option>
                    <option value=">">></option>
                    <option value="<"><</option>
                    <option value="<="><=</option>
                </x-tall-crud-select>
            </div>
            @endif

            @if ( $filter['type'] == 'None')
            <div class="mt-4">
                <x-tall-crud-label>Select Options (add as JSON)</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="filter.options" />
            </div>
            @endif

            @if ( $filter['type'] == 'BelongsTo' || $filter['type'] == 'BelongsToMany')
            <div class="mt-4">
                <x-tall-crud-label>
                    Relationship
                </x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-1/2"
                    wire:model.lazy="filter.relation">
                    <option value="">-Please Select-</option>
                    @if (Arr::exists($allRelations, 'belongsTo') && $filter['type'] == 'BelongsTo')
                    @foreach ($allRelations['belongsTo'] as $c)
                    <option value="{{$c['name']}}">{{$c['name']}}</option>
                    @endforeach
                    @endif
                    @if (Arr::exists($allRelations, 'belongsToMany')  && $filter['type'] == 'BelongsToMany')
                    @foreach ($allRelations['belongsToMany'] as $c)
                    <option value="{{$c['name']}}">{{$c['name']}}</option>
                    @endforeach
                    @endif
                </x-tall-crud-select>
                @error('filter.relation') <x-tall-crud-error-message>{{$message}}
                </x-tall-crud-error-message> @enderror
            </div>
            @if ( !empty($filter['relation']))
            <div class="mt-4">
                <x-tall-crud-label>
                    Column
                </x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-1/2"
                    wire:model.lazy="filter.column">
                    <option value="">-Please Select-</option>
                    @if (Arr::exists($filter, 'columns'))
                    @foreach ($filter['columns'] as $c)
                    <option value="{{$c}}">{{$c}}</option>
                    @endforeach
                    @endif
                </x-tall-crud-select>
                @error('filter.column') <x-tall-crud-error-message>{{$message}}
                </x-tall-crud-error-message> @enderror
            </div>
            @endif
            <x-tall-crud-label class="mt-4">
                Filter Multiple Values
                <x-tall-crud-checkbox class="ml-2" wire:model="filter.isMultiple" />
            </x-tall-crud-label>
            @endif
        </div>
        @endif
    </div>
</x-slot>

<x-slot name="footer">
    <x-tall-crud-button wire:click="$set('confirmingFilter', false)">Cancel</x-tall-crud-button>
    <x-tall-crud-button mode="add" wire:click="addFilter()">Save</x-tall-crud-button>
</x-slot>
</x-tall-crud-dialog-modal>
                @break



                @case(7)
                <div>
    <div>
        <x-tall-crud-label>Name of your Livewire Component</x-tall-crud-label>
        <x-tall-crud-input class="block mt-1 w-1/4" type="text" wire:model="componentName" required />
        @error('componentName') <x-tall-crud-error-message>{{$message}}
        </x-tall-crud-error-message>@enderror
    </div>

    @if($isComplete)
    <div class="flex items-center justify-end">
        @if ($exitCode == 0)
        <div>
            <div class="text-green-500 font-bold italic">
                Files Generated Successfully! <br />
                Use the Following code to render Livewire Component.
            </div>
            <div class="bg-black text-white text-2xl mt-2 p-4 rounded-md">{{$generatedCode}}</div>

        </div>
        @else
        <x-tall-crud-error-message>Files Could not be Generated.</x-tall-crud-error-message>
        @endif
    </div>
    @endif
</div>
                @break
 
                
        @endswitch
       
    </div>

    <div class="flex justify-between mt-4">
        @if($step != 1)
        <x-tall-crud-button class="ml-4" wire:click="moveBack">Previous</x-tall-crud-button>
        @else
        &nbsp;
        @endif
        <x-tall-crud-button class="mr-4" wire:click="moveAhead">
            {{$step != $totalSteps ? 'Next' : 'Generate Files' }}</x-tall-crud-button>
    </div>
</div>