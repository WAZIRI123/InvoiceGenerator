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
            
            @if(count($students))

            <div class="mt-4">
                    <x-tall-crud-label>Academic Year</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.academic_year_id">
                     <option value="">Please Select</option>
                     @foreach($academicYears as $c)
                    <option value="{{$c->id}}">{{$c->name}}<option>
                    @endforeach
                 </x-tall-crud-select>
                @error('item.academic_year_id')<x-tall-crud-error-message>{{$message}}<x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                    <x-tall-crud-label>Class</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.class_id">
                        <option value="">Please Select</option>
                        @foreach($classes as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.class_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>

            <div class="mt-4">
                    <x-tall-crud-label>section</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.section_id">
                        <option value="">Please Select</option>
                        @foreach($sections as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.section_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>


            <div class="mt-4">
                    <x-tall-crud-label>subject</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.subject_id">
                        <option value="">Please Select</option>
                        @foreach($subjects as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.subject_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
   
            </div>

            <div class="mt-4">
                    <x-tall-crud-label>exam</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.exam_id">
                        <option value="">Please Select</option>
                        @foreach($exams as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.exam_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
   
            </div>

            <div class="bg-white rounded-lg px-8 py-6 my-16 overflow-x-scroll custom-scrollbar">
            <table class="w-full my-8 whitespace-nowrap" wire:loading.class.delay="opacity-50">
            <thead class="bg-secondary text-gray-100 font-bold">
                <tr class="text-left font-bold bg-black-400">
                <td class="px-3 py-2" >#</td>
                <td class="px-3 py-2" >Student Name</td>
                <td class="px-3 py-2" >Roll No.</td>

                        @php
                            $marksDistributions = json_decode($examRule->marks_distribution);
                        @endphp
                            @foreach($marksDistributions as $distribution)
                            <td class="px-3 py-2" >{{AppHelper::MARKS_DISTRIBUTION_TYPES[$distribution->type]}}</td>
                       
                            @endforeach
                            <td class="px-3 py-2" >Total Marks</td>

                            <td class="px-3 py-2" >Absent</td>
                        </tr>
                        </thead>
                        <tbody>
                    @foreach($students as $student)
                <tr>
                <td class="px-3 py-2" >
                                    {{$loop->iteration}}
                </td>
                <td class="px-3 py-2" >

                <div class="mt-4">
                <x-tall-crud-label>{{$student->info->name}} [{{$student->regi_no}}</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="registrationIds" />
                @error('registrationIds') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>

            </td>
            <td class="px-3 py-2" >
            {{$student->roll_no}}
             </td>
             @foreach($marksDistributions$distribution)

            <td class="px-3 py-2" >
            <div class="mt-4">
            <x-tall-crud-label>Marks Obtained<x-tall-crud-label>
            <x-tall-crud-input class="block mt-1 w-full" type="number" wire:model="marks_type.{{$student->id}}.{{$distribution->marks_type}}" required max="{{$distribution->total_marks}}" min="0" />
                @error('type.{{$student->id}}.{{$distribution->type}}') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            </td>
                 @endforeach
                <td class="px-3 py-2" >
            
                </td>
                <td class="px-3 py-2" >
                <div class="mt-4">
                <x-tall-crud-label>Absent</x-tall-crud-label>

                <x-tall-crud-checkbox wire:model="absent.{{$student->id}}" />
                 Absent
         
            </div>
                 </td>
            </tr>
            @endforeach
             </tbody>
            <tfoot>
            <tr class="text-left font-bold bg-black-400">
            <td class="px-3 py-2" >#</td>
            <td class="px-3 py-2" >Student Name</td>
            <td class="px-3 py-2" >Roll No.</td>
            @foreach($marksDistributions as $distribution)
            <td class="px-3 py-2" >{{AppHelper::MARKS_DISTRIBUTION_TYPES[$distribution->type]}}</td>
            @endforeach
            <td class="px-3 py-2" >Total Marks</td>
            <td class="px-3 py-2" >Absent</td>

                            </tr>
                            </tfoot>
                        </table>
                    </div>

        @endif

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
                <x-tall-crud-label>Marks Obtained</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.marks_obtained" />
                @error('item.marks_obtained') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>

        ]
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
            </div><div class="grid grid-cols-2 gap-8">

            
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
            </div><div class="grid grid-cols-2 gap-8">

      
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
        </x-slot>

        <x-slot name="footer">
            <x-tall-crud-button wire:click="$set('confirmingItemEdit', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="add" wire:loading.attr="disabled" wire:click="editItem()">Save</x-tall-crud-button>
        </x-slot>
    </x-tall-crud-dialog-modal>
</div>
