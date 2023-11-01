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
                <x-tall-crud-label>Admission No</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.admission_no" />
                @error('item.admission_no') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Date Of Birth</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.date_of_birth" />
                @error('item.date_of_birth') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Date Of Admission</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.date_of_admission" />
                @error('item.date_of_admission') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Is Graduate</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.is_graduate" />
                @error('item.is_graduate') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>User Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.user_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.user_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Classes Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.classes_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.classes_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Stream Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.stream_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.stream_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Gender Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.gender_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.gender_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Semester Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.semester_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.semester_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Academic Year Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.academic_year_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.academic_year_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">

            <div class="grid grid-cols-3">
                <div class="mt-4">
                    <x-tall-crud-label>User</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.user_id">
                        <option value="">Please Select</option>
                        @foreach($users as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.user_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div>

            <div class="grid grid-cols-3">
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
            </div></div><div class="grid grid-cols-2 gap-8">

            <div class="grid grid-cols-3">
                <div class="mt-4">
                    <x-tall-crud-label>Stream</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.stream_id">
                        <option value="">Please Select</option>
                        @foreach($streams as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.stream_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div>

            <div class="grid grid-cols-3">
                <div class="mt-4">
                    <x-tall-crud-label>Gender</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.gender_id">
                        <option value="">Please Select</option>
                        @foreach($genders as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.gender_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
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
                    <x-tall-crud-label>AcademicYear</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.academic_year_id">
                        <option value="">Please Select</option>
                        @foreach($academicYears as $c)
                        <option value="{{$c->id}}">{{$c->academic_year}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.academic_year_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
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
                <x-tall-crud-label>Admission No</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.admission_no" />
                @error('item.admission_no') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Date Of Birth</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.date_of_birth" />
                @error('item.date_of_birth') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Date Of Admission</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.date_of_admission" />
                @error('item.date_of_admission') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Is Graduate</x-tall-crud-label>
                <x-tall-crud-input class="block mt-1 w-full" type="text" wire:model="item.is_graduate" />
                @error('item.is_graduate') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>User Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.user_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.user_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Classes Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.classes_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.classes_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Stream Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.stream_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.stream_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Gender Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.gender_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.gender_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">
            <div class="mt-4">
                <x-tall-crud-label>Semester Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.semester_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.semester_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>
            <div class="mt-4">
                <x-tall-crud-label>Academic Year Id</x-tall-crud-label>
                <x-tall-crud-select class="block mt-1 w-full" wire:model="item.academic_year_id"><option value="1">Yes</option><option value="0">No</option>
                </x-tall-crud-select> 
                @error('item.academic_year_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div></div><div class="grid grid-cols-2 gap-8">

            <div class="grid grid-cols-3">
                <div class="mt-4">
                    <x-tall-crud-label>User</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.user_id">
                        <option value="">Please Select</option>
                        @foreach($users as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.user_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div>

            <div class="grid grid-cols-3">
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
            </div></div><div class="grid grid-cols-2 gap-8">

            <div class="grid grid-cols-3">
                <div class="mt-4">
                    <x-tall-crud-label>Stream</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.stream_id">
                        <option value="">Please Select</option>
                        @foreach($streams as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.stream_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div>

            <div class="grid grid-cols-3">
                <div class="mt-4">
                    <x-tall-crud-label>Gender</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.gender_id">
                        <option value="">Please Select</option>
                        @foreach($genders as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.gender_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
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
                    <x-tall-crud-label>AcademicYear</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="item.academic_year_id">
                        <option value="">Please Select</option>
                        @foreach($academicYears as $c)
                        <option value="{{$c->id}}">{{$c->academic_year}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('item.academic_year_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
                </div>
            </div></div>
        </x-slot>

        <x-slot name="footer">
            <x-tall-crud-button wire:click="$set('confirmingItemEdit', false)">Cancel</x-tall-crud-button>
            <x-tall-crud-button mode="add" wire:loading.attr="disabled" wire:click="editItem()">Save</x-tall-crud-button>
        </x-slot>
    </x-tall-crud-dialog-modal>
</div>
