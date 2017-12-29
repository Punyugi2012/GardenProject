<?php
function formatLeaveTypeThai($type) {
    if($type == 'vacationleave') {
        return 'ลาพักร้อน';
    }
    elseif($type == 'personalleave') {
        return 'ลากิจ';
    }
    elseif($type == 'maternityleave') {
        return 'ลาครอด';
    }
    elseif($type == 'sickleave') {
        return 'ลาป่วย';
    }
}