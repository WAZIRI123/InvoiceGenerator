<?php

namespace App\Traits;

use App\Http\Helpers\AppHelper;

trait marksProcessing
{

   /**
     * Process student entry marks and
     * calculate grade point
     *
     * @param $examRule collection
     * @param $gradingRules array
     * @param $distributeMarksRules array
     * @param $strudnetMarks array
     */

     public function processMarksAndCalculateResult($examRule, $gradingRules, $distributeMarksRules, $studentMarks) {
        $totalMarks = 0;
        $isFail = false;
        $isInvalid = false;
        $message = "";
        $typeWiseMarks = [];

        foreach ($distributeMarksRules as $type => $marksRule){
            if(!isset($studentMarks[$type])){
                $typeWiseMarks[$type] = 0;
                continue;
            }

            $marks = floatval($studentMarks[$type]);
            $typeWiseMarks[$type] = $marks;
            $totalMarks += $marks;

                        // AppHelper::PASSING_RULES
            // 2=Individual,3=Over All & Individual
            // AppHelper::MARKS_DISTRIBUTION_TYPES= const MARKS_DISTRIBUTION_TYPES = [
            //     1 => "Written",
            //     2 => "MCQ",
            //     3 => "SBA",
            //     4 => "Attendance",
            //     5 => "Assignment",
            //     6 => "Lab Report",
            //     7 => "Practical",
            // ];
            // $distributeMarksRules[$type] it like written=>[
            //     'total_marks'=>30,
            //     'pass_marks' =>50,
            // ]

            if(in_array($examRule['passing_rule'], [2,3])){
                if($marks > $marksRule['total_marks']){
                    $isInvalid = true;
                    $message = AppHelper::MARKS_DISTRIBUTION_TYPES[$type]. " marks is too high from exam rules marks distribution!";
                    break;
                }

                if($marks < $marksRule['pass_marks']){
                    $isFail = true;
                }
            }
        }

        //fraction number make ceiling
        $totalMarks = ceil($totalMarks);

        // AppHelper::PASSING_RULES
        if(in_array($examRule['passing_rule'], [1,3])){
            if($totalMarks < $examRule['over_all_pass']){
                $isFail = true;
            }
        }

        if($isFail){
            $grade = 'F';
            $point = 0.00;
            return [$isInvalid, $message, $totalMarks, $grade, $point, $typeWiseMarks];
        }

        [$grade, $point] = $this->findGradePointFromMarks($gradingRules, $totalMarks);

        return [$isInvalid, $message, $totalMarks, $grade, $point, $typeWiseMarks];

    }

    public static function findGradePointFromMarks($gradingRules, $marks)
    {
        $grade = 'F';
        $point = 0.00;
        // $gradingRules it like $gradingRules=['a'=>['from'=>90,'to'=>100]]

    //    const GRADE_TYPES = [
    //     1 => 'A+',
    //     2 => 'A',
    //     3 => 'A-',
    //     4 => 'B',
    //     5 => 'C',
    //     6 => 'D',
    //     7 => 'F',
    // ];

        foreach ($gradingRules as $rule) {
            if ($marks >= $rule->marks_from && $marks <= $rule->marks_upto) {
                $grade = $rule->name;
                $point = 0.00;
                break;
            }
        }

        return [$grade, $point];
    }


}
