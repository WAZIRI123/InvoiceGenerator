<?php
namespace App\Traits;
use App\Http\Helpers\AppHelper;

 trait marksProcessing {

      /**
         * Process student entry marks and
         * calculate grade point
         *
         * @param $examRule collection
         * @param $gradingRules array
         * @param $distributeMarksRules array
         * @param $strudnetMarks array
         */
        private function processMarksAndCalculateResult($examRule, $gradingRules, $distributeMarksRules, $studentMarks) {
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
    
        private function findGradePointFromMarks($gradingRules, $marks) {
            $grade = 'F';
            $point = 0.00;
            foreach ($gradingRules as $rule){
                if ($marks >= $rule->marks_from && $marks <= $rule->marks_upto){
                    $grade = AppHelper::GRADE_TYPES[$rule->grade];
                    $point = $rule->point;
                    break;
                }
            }
            return [$grade, $point];
        }
    
        private function findGradeFromPoint($point, $gradingRules) {
            $grade = 'F';
    
            foreach ($gradingRules as $rule){
                if($point >= floatval($rule->point)){
                    $grade = AppHelper::GRADE_TYPES[$rule->grade];
                    break;
                }
            }
    
            return $grade;
    
        }


 }
 