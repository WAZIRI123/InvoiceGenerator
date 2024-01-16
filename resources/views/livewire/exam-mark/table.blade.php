<div>
<div class="bg-white rounded-lg px-8 py-6 my-16 overflow-x-scroll custom-scrollbar">
    <div class="flex justify-between">
        <div class="text-2xl">Exam_Results</div>
        <button type="submit" wire:click="$dispatchTo('exam-mark.create', 'showCreateForm');" class="text-blue-500">
            <x-tall-crud-icon-add />
        </button> 
    </div>

    <div class="mt-6">
    @livewire('livewire-toast')
        <div class="flex justify-between">
            <div class="flex">

            </div>
            <div class="flex">

                <x-tall-crud-page-dropdown />
            </div>
        </div>
           <div class="grid grid-cols-2 gap-8">

        <div class="mt-2">
                    <x-tall-crud-label>Academic Year</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="academic_year_id">
                     <option value="">Please Select</option>
                     @foreach($academicYears as $c)
                <option value="{{$c->id}}">{{$c->combined_dates}}</option>
                    @endforeach
                 </x-tall-crud-select>
                @error('academic_year_id')<x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>

        <div class="mt-2">
  
                    <x-tall-crud-label>Class</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model.live="class_id">
                        <option value="">Please Select</option>
                        @foreach($classes as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('class_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>

            <div class="mt-2">
                    <x-tall-crud-label>section</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="section_id">
                        <option value="">Please Select</option>
                        @foreach($sections as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('section_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>

            
            <div class="mt-2">
                    <x-tall-crud-label>subject</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="subject_id">
                        <option value="">Please Select</option>
                        @foreach($subjects as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('subject_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
            </div>

            <div class="mt-2">
                    <x-tall-crud-label>exam</x-tall-crud-label>
                    <x-tall-crud-select class="block mt-1 w-full" wire:model="exam_id">
                        <option value="">Please Select</option>
                        @foreach($exams as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </x-tall-crud-select>
                    @error('exam_id') <x-tall-crud-error-message>{{$message}}</x-tall-crud-error-message> @enderror
   
            </div>

                      <div class="mt-2">
                      <x-tall-crud-label class="invisible">exam</x-tall-crud-label>
                         <x-tall-crud-button mode="add" wire:loading.attr="disabled" wire:click="$refresh" class="w-full mt-2 justify-center">Show</x-tall-crud-button>
   
            </div>

     </div>

        <table class="w-full my-8 whitespace-nowrap" wire:loading.class.delay="opacity-50">
            <thead class="bg-secondary text-gray-100 font-bold">
                <tr class="text-left font-bold bg-black-400">
                <td class="px-3 py-2" >
                    <div class="flex items-center">
                        <button wire:click="sortBy('id')">Id</button>
                        <x-tall-crud-sort-icon sortField="id" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </div>
                </td>
                <td class="px-3 py-2" >Marks Obtained</td>
                <td class="px-3 py-2" >Student</td>
                <td class="px-3 py-2" >Semester</td>
                <td class="px-3 py-2" >Exam</td>
                <td class="px-3 py-2" >Subject</td>
                <td class="px-3 py-2" >Actions</td>
                </tr>
            </thead>
            <tbody class="divide-y divide-blue-400">
            @foreach($results as $result)
                <tr class="hover:bg-blue-300 {{ ($loop->even ) ? "bg-blue-100" : ""}}">
                    <td class="px-3 py-2" >{{ $result->id }}</td>
                    <td class="px-3 py-2" >{{ $result->total_marks }}</td>
                    <td class="px-3 py-2" >{{ $result->student?->admission_no }}</td>
                    <td class="px-3 py-2" >{{ $result->section?->name }}</td>
                    <td class="px-3 py-2" >{{ $result->exam?->name }}</td>
                    <td class="px-3 py-2" >{{ $result->subject?->name }}</td>
                    <td class="px-3 py-2" >
                        <button type="submit" wire:click="$dispatchTo('exam-mark.create', 'showEditForm', { examresult: {{ $result->id}} });" class="text-green-500">
                            <x-tall-crud-icon-edit />
                        </button>

                        <button type="submit" wire:click="$dispatchTo('exam-mark.create', 'showDeleteForm', { examresult: {{ $result->id}} });" class="text-red-500">
                            <x-tall-crud-icon-delete />
                        </button>
                    </td>
               </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $results->links() }}
    </div>
    @livewire('exam-mark.create')
   
</div>
 </div>