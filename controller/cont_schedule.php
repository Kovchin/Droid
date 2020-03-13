<?php

// Name: schedule editor

include_once '../controller/menu.php';

function sort_names($a, $b) {
    if ($a['obj_id'] == $b['obj_id']) {
        return 0;
    }
    return ($a['obj_id'] < $b['obj_id']) ? -1 : 1;
}

function sort_dates($a, $b) {
    if ($a['date'] == $b['date']) {
        return 0;
    }
    return ($a['date'] < $b['date']) ? -1 : 1;
}

$schedule = new database;

$cur_year = date('Y', time());
$cur_month = date('m', time());

$months = [
    [1, 'Январь'],
    [2, 'Февраль'],
    [3, 'Март'],
    [4, 'Апрель'],
    [5, 'Май'],
    [6, 'Июнь'],
    [7, 'Июль'],
    [8, 'Август'],
    [9, 'Сентябрь'],
    [10, 'Октябрь'],
    [11, 'Ноябрь'],
    [12, 'Декабрь'],
];

//Check sorting
if(isset($_GET['sort'])) {
    if($_GET['sort'] == 'day') {
        $sort = 'day';
    } elseif($_GET['sort'] == 'name') {
        $sort = 0;
    }
}

// check ERG section
if ($_COOKIE['erg_id'] == 'all') {
    $sch = $schedule->select_multi_where('schedule', ['month', 'year'], [$_COOKIE['month'], $_COOKIE['m_year']], 1);
} else {
    $sch = $schedule->select_multi_where('schedule', ['erg_id', 'month', 'year'], [$_COOKIE['erg_id'], $_COOKIE['month'], $_COOKIE['m_year']], 1);
}

//Max month day
$time = strtotime('01-' . $_COOKIE['month'] . '-' . $_COOKIE['m_year']);
$max_m = date('t', $time);

//Year determination

$check_year = $cur_year - 2;
$year_list = [];
for ($i = 0; $i < 6; $i++, $check_year++) {
    $year_list[$i][0] = $check_year;
    $year_list[$i][1] = '';
    if ($check_year == $_COOKIE['m_year']) {
        $year_list[$i][1] = ' selected';
    }
}

// Schedule table display
for ($i = 0; $i < count($sch); $i++) {
    $temp = $schedule->select_where('objects', 'id', $sch[$i]['obj_id']);
    $sch[$i]['obj_id'] = $temp['name'];
    $sch[$i]['disabled'] = '';
    if ($sch[$i]['day'] == 0) {
        $sch[$i]['date'] = '';
    } else {
        $sch[$i]['date'] = $sch[$i]['year'] . '-' .
                sprintf('%02d', $sch[$i]['month']) . '-' .
                sprintf('%02d', $sch[$i]['day']);
    }
    if ($sch[$i]['date'] != '') {
        if (((strtotime($sch[$i]['date']) < time() - 86400) && ($_SESSION['login'] != 'admin'))) {
            $sch[$i]['disabled'] = ' disabled';
        }
    }
    if(!$auth) {
        $sch[$i]['disabled'] = ' disabled';
    }
}

if(isset($_GET['sort'])) {
    if($_GET['sort'] == 'day') {
        uasort($sch, 'sort_dates');
    } elseif($_GET['sort'] == 'name') {
        uasort($sch, 'sort_names');
    }
}

$coun = 1;
