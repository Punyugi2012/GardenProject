<?php
function formatNationalityThai($nationality) {
    if($nationality == 'Thai') {
        return 'ไทย';
    }
    elseif($nationality == 'Vietnamese') {
        return 'เวียดนาม';
    }
    elseif($nationality == 'Singaporean') {
        return 'สิงคโปร์';
    }
    elseif($nationality == 'Burmese') {
        return 'พม่า';
    }
    elseif($nationality == 'Lao') {
        return 'ลาว';
    }
    elseif($nationality == 'Indonesian') {
        return 'อินโดนีเซีย';
    }
    elseif($nationality == 'Cambodian') {
        return 'กัมพูชา';
    }
}