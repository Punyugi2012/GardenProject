<?php
use Carbon\Carbon;
function checkSymbolFirst($strDate) {
   if(strpos($strDate, '-')) {
        return true;
   }
   return false;
}
function checkSymbolSecond($strDate) {
    if(strpos($strDate, ':')) {
        return true;
   }
   return false;
}
function formatDateThai($strDate)
{
    $checkFirst = checkSymbolFirst($strDate);
    $checkSecond = checkSymbolSecond($strDate);
 
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("j",strtotime($strDate));
    $strHour= date("H",strtotime($strDate));
    $strMinute= date("i",strtotime($strDate));
    $strSeconds= date("s",strtotime($strDate));
    $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $strMonthThai=$strMonthCut[$strMonth];
    
    if($checkFirst && $checkSecond) {
        return "$strDay $strMonthThai $strYear $strHour:$strMinute";
    }
    elseif($checkFirst) {
        return "$strDay $strMonthThai $strYear";
    }
    else {
        return "$strHour:$strMinute";
    }
}