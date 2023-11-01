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

        <x-slot name="content"><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Student Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.student_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.student_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Exam Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.exam_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.exam_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Subject Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.subject_id">
                <option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.subject_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Semester Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.semester_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.semester_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Marks Obtained</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.marks_obtained" />
                @error('item.marks_obtained') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>

            <div class="grid grid-cols-3">
                <div class="mt-4">
                    <x-tall-crud-label>Student</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.student_id">
                        <option value="">Please Select</option>
                        @foreach($students as $c)
                        <option value="{{$c->id}}">{{$c->admission_no}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.student_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div></div><div class="grid grid-cols-2 gap-8">

            <div class="grid grid-cols-3">
                <div class="mt-4">
                    <x-tall-crud-label>Semester</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.semester_id">
                        <option value="">Please Select</option>
                        @foreach($semesters as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.semester_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div>

            <div class="grid grid-cols-3">
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
            </div></div><div class="grid grid-cols-2 gap-8">

            <div class="grid grid-cols-3">
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
            </div></div>
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
                <x-tall-crud-label>Student Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.student_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.student_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Exam Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.exam_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.exam_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Subject Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.subject_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.subject_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Semester Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.semester_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.semester_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Marks Obtained</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.marks_obtained" />
                @error('item.marks_obtained') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>

            <div class="grid grid-cols-3">
                <div class="mt-4">
                    <x-tall-crud-label>Student</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.student_id">
                        <option value="">Please Select</option>
                        @foreach($students as $c)
                        <option value="{{$c->id}}">{{$c->admission_no}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.student_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div></div><div class="grid grid-cols-2 gap-8">

            <div class="grid grid-cols-3">
                <div class="mt-4">
                    <x-tall-crud-label>Semester</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.semester_id">
                        <option value="">Please Select</option>
                        @foreach($semesters as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.semester_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div>

            <div class="grid grid-cols-3">
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
            </div></div><div class="grid grid-cols-2 gap-8">

            <div class="grid grid-cols-3">
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
            </div></div>
        </x-slot>

        <x-slot name="footer">
            <x-tall-crud-button wire:click="$set('confirmingItemEdit', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="add" wire:loading.attr="disabled" wire:click="editItem()">Save</x-tall-crud-button>
        </x-slot>
    </x-tall-crud-dialog-modal>
</div>
