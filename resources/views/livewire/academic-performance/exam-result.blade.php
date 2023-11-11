<div>
<div class="bg-white rounded-lg px-8 py-6 my-16 overflow-x-scroll custom-scrollbar">
            <div class="bg-white rounded-lg px-8 py-6 overflow-x-scroll custom-scrollbar">
                <h4 class="text-xl font-semibold">Recent Reservations</h4>
                <table class="w-full my-8 whitespace-nowrap">
    <thead class="bg-secondary text-gray-100 font-bold">
        <tr>
            <th class="px-3 py-2">Student Name</th>
            <th class="px-3 py-2">Admission Number</th>
            <th class="px-3 py-2">Semester</th>
            <th class="px-3 py-2">Stream</th>
            <th class="px-3 py-2">Date of Admission</th>
            <th class="px-3 py-2">Graduate</th>
            <th class="px-3 py-2">Action</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-blue-400">
        @foreach ($students as $student)
            <tr class="hover:bg-blue-300 {{ $loop->even ? 'bg-blue-100' : '' }}">
                <td class="px-3 py-2">{{ $student->user->name }}</td>
                <td class="px-3 py-2">{{ $student->admission_no }}</td>
                <td class="px-3 py-2">{{ $student->semester->name }}</td>
                <td class="px-3 py-2">{{ $student->stream->name }}</td>
                <td class="px-3 py-2">{{ $student->date_of_admission }}</td>
                <td class="px-3 py-2">{{ $student->is_graduate ? 'Yes' : 'No' }}</td>

                <td class="px-3 py-2">
                <button type="submit" wire:click.live="showStudentResult({{ $student->id}})" class="text-green-500">
                <x-custom-components.icon-edit />
                        </button>
                  
                </td>
            </tr>
       @endforeach
    </tbody>
</table>
            </div>
        </div>
@if ($data)
        <x-custom-components.confirmation-dialog wire:model.live="confirmingItemView">
        <x-slot name="title" >
            View
        </x-slot>

        <x-slot name="content">
        <fieldset class="legend" style="background-color: transparent;
    color: #0303e6;
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 12px;
    text-align: left;
    width: auto;">
    <br>
    <p align="center">
        <font color="navy" size="3"><b>Student Examination Results</b></font>
    </p>
    <table border="0">
        <tbody>
            <tr style="font-size: 11px; line-height: 11px;">
                <td align="left" style="padding-right: 24px;"><b>Name:</b></td>
                <td align="left">
                    <font color="navy"><b>{{ $data['Student Information']['Name'] }}</b></font>
                </td>
            </tr>
            <tr style="font-size: 11px; line-height: 11px;">
                <td align="left" style="padding-right: 24px;"><b>Registration No.:</b></td>
                <td align="left">
                    <font color="navy"><b>{{ $data['Student Information']['Admission No'] }}</b></font>
                </td>
            </tr>
            <tr style="font-size: 11px; line-height: 11px;">
                <td align="left" style="padding-right: 24px;"><b>Programme:</b></td>
                <td align="left">
                    <font color="navy"><b>{{ $data['Student Information']['Admission No'] }}</b></font>
                </td>
            </tr>
        </tbody>
    </table>
    <p><br></p>
    <!-- Display exam results for each semester here -->
 
    <table align="left" style="font-family: verdana, arial, sans-serif;
        font-size: 11px;
        color: blue;
        border-width: 1px;
        border-color: black;
        border-collapse: collapse;" border="1" bordercolor="#FFFFFF" width="100%">
        <tbody>
            <tr style="font-size: 11px; line-height: 11px;">
                <th style="background: #dadafc;
                    border-width: 1px;
                    padding: 3px;
                    border-style: ridge;
                    border-color: black;
                    font-size: 13px;
                    font-weight: bold;
                    color: blue;" colspan="100"> * Semester:1</th>
            </tr>
            <tr bgcolor="#ADC8AE" style="background-color: rgb(173, 200, 174);">
                <td class="result_tables" align="center"><b>S/No.</b></td>
                <td class="result_tables" colspan="2"><b>Exam</b></td>
                
                <td class="result_tables" colspan="2"><b>Subject</b></td>
                <td class="result_tables" colspan="2"><b>Score</b></td>
                <td class="result_tables"><b>Grade</b></td>
                
            </tr>
            @foreach ($data['Semester Results']['Semester 1'] as $result)
            <tr border="0" bgcolor="#d7fbdd" style="color:black;">
                <td style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" class="result_tables" align="center">{{$loop->index +1}}</td>
                <td style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" class="result_tables" colspan="2">{{ $result->exam?->name}}</td>
                <td style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" class="result_tables" colspan="2">{{ $result->subject?->name}}</td>

                <td style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" class="on_save_tables" colspan="2"><b>{{ $result->marks_obtained}}</b></td>

                <td style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" class="on_save_tables"><b> {{ $data['Subject Grades Semester 1'][$result->subject->name]['Grade'] ?? '' }}</b></td>

            </tr>
            @endforeach
            <!-- Add more data rows for the current semester as needed -->
        </tbody>
    </table>
   

    <!-- Display cumulative average and class rank here -->
    <table align="left" border="1" style="font-family: verdana, arial, sans-serif;
        font-size: 11px;
        color: blue;
        border-width: 1px;
        border-color: black;
        border-collapse: collapse;" width="50%">
        <tbody>
            <tr style="font-size: 11px; line-height: 11px;">
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="left"><b>Cumulative Average</b></td>
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="center">{{ $data['Cumulative Average Semester 1'] }}</td>
            </tr>
            <tr style="font-size: 11px; line-height: 11px;">
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="left"><b>semester  Grade</b></td>
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="center">{{ $data['Grade Semester1'] }}</td>
            </tr>
            <tr style="font-size: 11px; line-height: 11px;">
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="left"><b>Rank</b></td>
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="center">{{ $data['Semester Ranks']['Semester 1'] }}</td>
            </tr>
            
            <tr style="font-size: 11px; line-height: 11px;">
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="left"><b>Student's Status</b></td>
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="center">{{ $data['status Semester1'] }}</td>
            </tr>
        </tbody>
    </table>
    <br>
@if (count($data['Semester Results']['Semester 2'])>0)

    <table align="left" style="font-family: verdana, arial, sans-serif;
        font-size: 11px;
        color: blue;
        border-width: 1px;
        border-color: black;
        border-collapse: collapse;" border="1" bordercolor="#FFFFFF" width="100%">
        <tbody>
            <tr style="font-size: 11px; line-height: 11px;">
                <th style="background: #dadafc;
                    border-width: 1px;
                    padding: 3px;
                    border-style: ridge;
                    border-color: black;
                    font-size: 13px;
                    font-weight: bold;
                    color: blue;" colspan="100"> * Semester:2</th>
            </tr>
            <tr bgcolor="#ADC8AE" style="background-color: rgb(173, 200, 174);">
                <td class="result_tables" align="center"><b>S/No.</b></td>
                <td class="result_tables" colspan="2"><b>Exam</b></td>
                
                <td class="result_tables" colspan="2"><b>Subject</b></td>
                <td class="result_tables" colspan="2"><b>Score</b></td>
                <td class="result_tables"><b>Grade</b></td>
    
            </tr>
            @foreach ($data['Semester Results']['Semester 2'] as $result)
            <tr border="0" bgcolor="#d7fbdd" style="color:black;">
                <td style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" class="result_tables" align="center">{{$loop->index +1}}</td>
                <td style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" class="result_tables" colspan="2">{{ $result->exam?->name}}</td>
                <td style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" class="result_tables" colspan="2">{{ $result->subject?->name}}</td>

                <td style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" class="on_save_tables" colspan="2"><b>{{ $result->marks_obtained}}</b></td>

                <td style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" class="on_save_tables"><b> {{ $data['Subject Grades Semester 2'][$result->subject->name]['Grade'] ?? '' }}</b></td>

            </tr>
            @endforeach
            <!-- Add more data rows for the current semester as needed -->
        </tbody>
    </table>
   

    <!-- Display cumulative average and class rank here -->
    <table align="left" border="1" style="font-family: verdana, arial, sans-serif;
        font-size: 11px;
        color: blue;
        border-width: 1px;
        border-color: black;
        border-collapse: collapse;" width="50%">
        <tbody>
            <tr style="font-size: 11px; line-height: 11px;">
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="left"><b>Cumulative Average</b></td>
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="center">{{ $data['Cumulative Average Semester 2'] }}</td>
            </tr>
            <tr style="font-size: 11px; line-height: 11px;">
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="left"><b>semester  Grade</b></td>
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="center">{{ $data['Grade Semester2'] }}</td>
            </tr>
            <tr style="font-size: 11px; line-height: 11px;">
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="left"><b>Rank</b></td>
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="center">{{ $data['Semester Ranks']['Semester 2'] }}</td>
            </tr>
            
            <tr style="font-size: 11px; line-height: 11px;">
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="left"><b>Student's Status</b></td>
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="center">{{ $data['status Semester2'] }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    
    
        <!-- Display cumulative average and class rank here -->
        <table align="left" border="1" style="font-family: verdana, arial, sans-serif;
        font-size: 11px;
        color: blue;
        border-width: 1px;
        border-color: black;
        border-collapse: collapse;" width="50%">
        <tbody>
            <tr style="font-size: 11px; line-height: 11px;">
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="left"><b>Year Average</b></td>
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="center">{{ $data['Overall Cumulative Average'] }}</td>
            </tr>
            <tr style="font-size: 11px; line-height: 11px;">
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="left"><b>Year  Grade</b></td>
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="center">{{ $data['Overall Grade'] }}</td>
            </tr>
            <tr style="font-size: 11px; line-height: 11px;">
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="left"><b>Year Rank</b></td>
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="center">{{ $data['Overall Rank']}}</td>
            </tr>
            
            <tr style="font-size: 11px; line-height: 11px;">
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="left"><b>Student's Status</b></td>
                <td class="" style="background: #ececfb; border-width: 1px; padding: 3px; border-style: ridge; border-color: black; color: blue;" align="center">{{ $data['Year Status'] }}</td>
            </tr>
        </tbody>
    </table>
    <br>  
@endif
</fieldset>

        </x-slot>

        <x-slot name="footer">
            <x-custom-components.button wire:click="$set('confirmingItemView', false)">Cancel</x-custom-components.button>
            <x-custom-components.button mode="delete" wire:loading.attr="disabled" wire:click="deleteItem()">Print</x-custom-components.button>
        </x-slot>
    </x-custom-components.confirmation-dialog>
    @endif
        
</div>
