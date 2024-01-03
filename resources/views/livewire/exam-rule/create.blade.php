<div>

    <x-tall-crud-confirmation-dialog wire:model.live="confirmingItemDeletion">
        <x-slot name="title">
            Delete Record
        </x-slot>

        <x-slot name="content">
            Are you sure you want to Delete Record?
        </x-slot>

        <x-slot name="footer">
            <x-tall-crud-button wire:click="$set('confirmingItemDeletion', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="delete" wire:loading.attr="disabled" wire:click="deleteItem()">Delete</x-tall-crud-button>
        </x-slot>
    </x-tall-crud-confirmation-dialog>


    <x-tall-crud-dialog-modal wire:model.live="confirmingItemCreation">
        <x-slot name="title">
            Add Record
        </x-slot>

        <x-slot name="content">            
            <div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Total Exam Marks</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="number" wire:model="item.total_exam_marks" />
                @error('item.total_exam_marks') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Over All Pass</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="number" wire:model="item.over_all_pass" />
                @error('item.over_all_pass') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div>
            
            <div class="grid grid-cols-2 gap-8">

                <div class="mt-4">
                    <x-tall-crud-label>Class</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.classes_id">
                        <option value="">Please Select</option>
                        @foreach($classes as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.classes_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
      
                <div class="mt-4">
                    <x-tall-crud-label>Exam</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model.live="exam">
                        <option value="">Please Select</option>
                        @foreach($exams as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('exam') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-tall-crud-label>CombineSubject</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.combine_subject_id">
                        <option value="">Please Select</option>
                        @foreach($combineSubjects as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.combine_subject_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>


                <div class="mt-4">
                    <x-tall-crud-label>Subject</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.subject_id">
                        <option value="">Please Select</option>
                        @foreach($subjects as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.subject_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-8">

            <div class="mt-4">
                    <x-tall-crud-label>Passing Rule</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.passing_rule">
                        <option value="">Please Select</option>
                        @foreach(\AppHelper::PASSING_RULES as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.passing_rule') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>


</div>
            <div class="grid grid-cols-1 gap-8 mb-3">

            <div class="mt-4">
    <div class="grid grid-cols-2 md:grid-cols-3 gap-1">
    @foreach($markDistTypes as $key => $value)
    <div class="mt-4 md:mt-0"> 
        <x-tall-crud-label>Marks Distribute Type</x-tall-crud-label>
        <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model.live="marks_distribution.type.{{$key}}" />
@error('marks_distribution.type.'.$key) <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
        @error('marks_distribution.type.'.$key) <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
    </div>
    <div class="mt-4 md:mt-0">
        <x-tall-crud-label>Total Marks</x-tall-crud-label>
        <x-tall-crud-input class="block mt-1 w-full" type="number" wire:model="marks_distribution.total_marks.{{$key}}" placeholder="Total Marks" />
        @error('marks_distribution.total_marks.'.$key) <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
    </div>
    <div class="mt-4 md:mt-0">
        <x-tall-crud-label>Pass Marks</x-tall-crud-label>
        <x-tall-crud-input class="block mt-1 w-full" type="number" wire:model="marks_distribution.pass_marks.{{$key}}" placeholder="Pass Marks" />
        @error('marks_distribution.pass_marks.'.$key) <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
    </div>
   
 
    @endforeach

            </div>

            </div>

        </x-slot>

        <x-slot name="footer">
            <x-tall-crud-button wire:click="$set('confirmingItemCreation', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="add" wire:loading.attr="disabled" wire:click="createItem()">Save</x-tall-crud-button>
        </x-slot>
    </x-tall-crud-dialog-modal>
    
    <x-tall-crud-dialog-modal wire:model.live="confirmingItemEdit">
        <x-slot name="title">
            Edit Record
        </x-slot>

        <x-slot name="content"><div class="grid grid-cols-2 gap-8">
        
    
            <div class="mt-4">
                <x-tall-crud-label>Passing Rule</x-tall-crud-label>
                <x-tall-crud-input placeholder="Passing Rule" class="block mt-1 w-full" type="number" wire:model="item.passing_rule" />
                @error('item.passing_rule') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
        </div>
            <div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Total Exam Marks</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="number" wire:model="item.total_exam_marks" />
                @error('item.total_exam_marks')<x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Over All Pass</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="number" wire:model="item.over_all_pass" />
                @error('item.over_all_pass') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
        </div>
        <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-tall-crud-label>Class</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.classes_id">
                       
                        @foreach($classes as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.classes_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div>

           
                <div class="mt-4">
                    <x-tall-crud-label>Exam</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.exam_id">
                        <option value="">Please Select</option>
                        @foreach($exams as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.exam_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div>
      <div class="grid grid-cols-2 gap-8">

                <div class="mt-4">
                    <x-tall-crud-label>CombineSubject</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.combine_subject_id">
                        <option value="">Please Select</option>
                        @foreach($combineSubjects as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.combine_subject_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div>

           
                <div class="mt-4">
                    <x-tall-crud-label>Subject</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.subject_id">
                        <option value="">Please Select</option>
                        @foreach($subjects as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.subject_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-8">

 

            <div class="mt-4">
                    <x-tall-crud-label>Passing Rule</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.passing_rule">
                        <option value="">Please Select</option>
                        @foreach(\AppHelper::PASSING_RULES as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.passing_rule') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>

</div>
            <div class="grid grid-cols-1 gap-8 mb-3">
            <div class="mt-4">
    <div class="grid grid-cols-2 md:grid-cols-3 gap-1">
    @foreach($markDistTypes as $key => $value)
    <div class="mt-4 md:mt-0"> 
        <x-tall-crud-label>Marks Distribute Type</x-tall-crud-label>
        <x-tall-crud-select class="block mt-1 w-full" wire:model="type.{{$key}}">
            <option value="">Please Select</option>
            @foreach($markDistTypes as $id => $name)
            <option value="{{$id}}">{{$name}}</option>
            @endforeach
        </x-tall-crud-select>
        @error('type.'.$key) <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
    </div>
    <div class="mt-4 md:mt-0">
        <x-tall-crud-label>Total Marks</x-tall-crud-label>
        <x-tall-crud-input class="block mt-1 w-full" type="number" wire:model="total_marks.{{$key}}" placeholder="Total Marks" />
        @error('total_marks.'.$key) <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
    </div>
    <div class="mt-4 md:mt-0">
        <x-tall-crud-label>Pass Marks</x-tall-crud-label>
        <x-tall-crud-input class="block mt-1 w-full" type="number" wire:model="pass_marks.{{$key}}" placeholder="Pass Marks" />
        @error('pass_marks.'.$key) <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
    </div>
   
    @endforeach

            </div>


            </div>
        
        </x-slot>

        <x-slot name="footer">
            <x-tall-crud-button wire:click="$set('confirmingItemEdit', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="add" wire:loading.attr="disabled" wire:click="editItem()">Save</x-tall-crud-button>
        </x-slot>
    </x-tall-crud-dialog-modal>

    
    <x-tall-crud-dialog-modal wire:model.live="confirmingItemEdit">
        <x-slot name="title">
            Edit Record
        </x-slot>

        <x-slot name="content">            
            <div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Total Exam Marks</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="number" wire:model="item.total_exam_marks" />
                @error('item.total_exam_marks') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Over All Pass</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="number" wire:model="item.over_all_pass" />
                @error('item.over_all_pass') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div>
            
            <div class="grid grid-cols-2 gap-8">

                <div class="mt-4">
                    <x-tall-crud-label>Class</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.classes_id">
                   
                        @foreach($classes as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.classes_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
      
                <div class="mt-4">
                    <x-tall-crud-label>Exam</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model.live="exam">
                       
                        @foreach($exams as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('exam') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-8">
                <div class="mt-4">
                    <x-tall-crud-label>CombineSubject</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.combine_subject_id">
                       
                        @foreach($combineSubjects as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.combine_subject_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>


                <div class="mt-4">
                    <x-tall-crud-label>Subject</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.subject_id">
                       
                        @foreach($subjects as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.subject_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-8">

            <div class="mt-4">
                    <x-tall-crud-label>Passing Rule</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.passing_rule">
                       
                        @foreach(\AppHelper::PASSING_RULES as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.passing_rule') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>


</div>
            <div class="grid grid-cols-1 gap-8 mb-3">

            <div class="mt-4">
    <div class="grid grid-cols-2 md:grid-cols-3 gap-1">
    @foreach($markDistTypes as $key => $value)
    <div class="mt-4 md:mt-0"> 
        <x-tall-crud-label>Marks Distribute Type</x-tall-crud-label>
        <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model.live="marks_distribution.type.{{$key}}" />
        @error('marks_distribution.type.'.$key) <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
    </div>
    <div class="mt-4 md:mt-0">
        <x-tall-crud-label>Total Marks</x-tall-crud-label>
        <x-tall-crud-input class="block mt-1 w-full" type="number" wire:model.live="marks_distribution.total_marks.{{$key}}" placeholder="Total Marks" />
        @error('marks_distribution.total_marks.'.$key) <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
    </div>
    <div class="mt-4 md:mt-0">
        <x-tall-crud-label>Pass Marks</x-tall-crud-label>
        <x-tall-crud-input class="block mt-1 w-full" type="number" wire:model.live="marks_distribution.pass_marks.{{$key}}" placeholder="Pass Marks" />
        @error('marks_distribution.pass_marks.'.$key) <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
    </div>
   
    @endforeach

            </div>

            </div>

        </x-slot>

        <x-slot name="footer">
            <x-tall-crud-button wire:click="$set('confirmingItemEdit', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="add" wire:loading.attr="disabled" wire:click="editItem()">Save</x-tall-crud-button>
        </x-slot>
    </x-tall-crud-dialog-modal>
</div>
