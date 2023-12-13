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
                    <x-tall-crud-label>Grade</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.grade_id">
                        <option value="">Please Select</option>
                        @foreach($grades as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.grade_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
 
            <div class="mt-4">
                <x-tall-crud-label>Passing Rule</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.passing_rule" />
                @error('item.passing_rule') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
        </div>
            
            <div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Total Exam Marks</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.total_exam_marks" />
                @error('item.total_exam_marks') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Over All Pass</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.over_all_pass" />
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
            
            <div class="grid grid-cols-1 gap-8">

            <div class="mt-4">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-1">
    @foreach($MarksDistFields as $key => $value)
    <div class="mt-4 md:mt-0"> 
        <x-tall-crud-label>Marks Distribute Type</x-tall-crud-label>
        <x-tall-crud-select class="block mt-1 w-full" wire:model="marksDistType.{{$key}}">
            <option value="">Please Select</option>
            @foreach($markDistTypes as $id => $name)
            <option value="{{$id}}">{{$name}}</option>
            @endforeach
        </x-tall-crud-select>
        @error('marksDistType.'.$key) <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
    </div>
    <div class="mt-4 md:mt-0">
        <x-tall-crud-label>Total Marks</x-tall-crud-label>
        <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="total_marks.{{$key}}" placeholder="Total Marks" />
        @error('total_marks.'.$key) <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
    </div>
    <div class="mt-4 md:mt-0">
        <x-tall-crud-label>Pass Marks</x-tall-crud-label>
        <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="pass_marks.{{$key}}" placeholder="Pass Marks" />
        @error('pass_marks.'.$key) <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
    </div>
   
    <div class="flex flex-col md:flex-row items-start md:items-center md:justify-center mt-4 md:mt-0">
    
        <button type="submit" wire:click="addMarksDistField()" class="text-blue-500 md:mr-1 mt-4">
            <x-tall-crud-icon-add />
        </button> 
        @if($key != 0)
        <button class="text-red-500 mt-4" wire:click="removeMarksDistField('{{$key}}')">
            <x-tall-crud-icon-delete />
        </button> 
        @endif
    </div>
    @endforeach

            </div>

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
                    <x-tall-crud-label>Grade</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.grade_id">
                        <option value="">Please Select</option>
                        @foreach($grades as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.grade_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            <div class="mt-4">
                <x-tall-crud-label>Passing Rule</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.passing_rule" />
                @error('item.passing_rule') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
        </div>
            <div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Total Exam Marks</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.total_exam_marks" />
                @error('item.total_exam_marks') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Over All Pass</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.over_all_pass" />
                @error('item.over_all_pass') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
        </div>
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
            <div class="grid grid-cols-1 gap-8">
            <div class="mt-4">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-1">
    @foreach($MarksDistFields as $key => $value)
    <div class="mt-4 md:mt-0"> 
        <x-tall-crud-label>Marks Distribute Type</x-tall-crud-label>
        <x-tall-crud-select class="block mt-1 w-full" wire:model="marksDistType.{{$key}}">
            <option value="">Please Select</option>
            @foreach($markDistTypes as $id => $name)
            <option value="{{$id}}">{{$name}}</option>
            @endforeach
        </x-tall-crud-select>
        @error('marksDistType.'.$key) <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
    </div>
    <div class="mt-4 md:mt-0">
        <x-tall-crud-label>Total Marks</x-tall-crud-label>
        <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="total_marks.{{$key}}" placeholder="Total Marks" />
        @error('total_marks.'.$key) <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
    </div>
    <div class="mt-4 md:mt-0">
        <x-tall-crud-label>Pass Marks</x-tall-crud-label>
        <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="pass_marks.{{$key}}" placeholder="Pass Marks" />
        @error('pass_marks.'.$key) <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
    </div>
   
    <div class="flex flex-col md:flex-row items-start md:items-center md:justify-center mt-4 md:mt-0">
    
        <button type="submit" wire:click="addMarksDistField()" class="text-blue-500 md:mr-1 mt-4">
            <x-tall-crud-icon-add />
        </button> 
        @if($key != 0)
        <button class="text-red-500 mt-4" wire:click="removeMarksDistField('{{$key}}')">
            <x-tall-crud-icon-delete />
        </button> 
        @endif
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
