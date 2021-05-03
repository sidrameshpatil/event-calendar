<?php

include_once "functions.php";



// this class has all the reuired methods for calendar related operations

class Calendar {

    public $year;
    function __construct($year){
        $this->year = $year;
    }

    public function getDaysInMonth($month){
        return cal_days_in_month(CAL_GREGORIAN, $month, $this->year);
    }

    public function firstDayOfMonth($month){
        $date = $this->year."-".$month."-01";
        return date("N",strtotime($date));
    }

    public function whichDay($month, $day){
        $date = $this->year."-".$month."-".$day;
        if(strtotime($date) == strtotime(date('Y-m-d'))){
            return 0;
        }else if(strtotime($date) < strtotime(date('Y-m-d'))){
            return -1;
        }else{
            return 1;
        }
    }

    public function checkEvents($month, $day){
        
        $date = $this->year."-".$month."-".$day;
        $events = getEvents($date);
        // echo count($events);
        if(count($events) == 0){
            return false;
        }else{
            return true;
        }
    }

    public function getYearList(){
        $yearInit = $this->year; 
        $yearPrev = ($yearInit - 5); 
        $yearNext = ($yearInit + 5); 
        $options = ''; 
        for($i=$yearPrev;$i<=$yearNext;$i++){ 
            $selectedOpt = ($i == $this->year)?'selected':''; 
            $options .= '<option value="'.$i.'" '.$selectedOpt.' >'.$i.'</option>'; 
        } 
        return $options;
    }
}

$numberToMonth = array(
    1 => "Jan",
    2 => "Feb",
    3 => "Mar",
    4 => "Apr",
    5 => "May",
    6 => "Jun",
    7 => "Jul",
    8 => "Aug",
    9 => "Sep",
    10 => "Oct",
    11 => "Nov",
    12 => "Dec"
)

?>