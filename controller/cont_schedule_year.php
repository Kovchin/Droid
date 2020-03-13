<?php

// Name: schedule editor

include_once '../controller/menu.php';

$cur_year = date('Y', time());

// year selection
$check_year = $cur_year - 2;
$year_list = [];
for($i = 0; $i < 8; $i++, $check_year++) {
    $year_list[$i][0] = $check_year;
    $year_list[$i][1] = '';
    if($check_year == $_COOKIE['year']) {
        $year_list[$i][1] = ' selected';
    }
}