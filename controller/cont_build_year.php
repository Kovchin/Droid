<?php

// Name: schedule editor

include_once '../controller/menu.php';

function sort_names($a, $b) {
    if ($a['erg_id'] == $b['erg_id']) {
        if ($a['name'] == $b['name']) {
            return 0;
        }
        return ($a['name'] < $b['name']) ? -1 : 1;
    }
    return ($a['erg_id'] < $b['erg_id']) ? -1 : 1;
}

$year = new database;

$sign_data = $year->select_all('signs');

//Year determination

$check_year = $cur_year - 2;
$year_list = [];
for($i = 0; $i < 6; $i++, $check_year++) {
    $year_list[$i][0] = $check_year;
    $year_list[$i][1] = '';
    if($check_year == $_COOKIE['year']) {
        $year_list[$i][1] = ' selected';
    }
}

// Processing pushed buttons
if(isset($_POST['submit'])) {
    setcookie('year', $_POST['year']);
    setcookie('month', $_POST['month']);
    header("Location: ./build_year.php");
}

if ($_COOKIE['erg_id'] == 'all') {
    $yt_sch = $year->select_multi_where('schedule', ['year'], [$_COOKIE['year']], 1, 'obj_id');
} else {
    $yt_sch = $year->select_multi_where('schedule', ['erg_id', 'year'], [$_COOKIE['erg_id'], $_COOKIE['year']], 1, 'obj_id');
}
$y_sch = [];

for ($i = 0; $i < count($yt_sch); $i++) {
    if ($i != count($yt_sch) - 1) {
        if ($yt_sch[$i]['obj_id'] == $yt_sch[$i + 1]['obj_id']) {
            $month[] = $yt_sch[$i]['month'];
            continue;
        }
    }

    $month[] = $yt_sch[$i]['month'];
    $obj = $year->select_where('objects', 'id', $yt_sch[$i]['obj_id']);
    $eqp = $year->select_cols_where('equipment', ['type', 'name', 'quantity'], 'object_id', $yt_sch[$i]['obj_id'], 1);
    $yt_sch[$i]['name'] = $obj['name'];
    $yt_sch[$i]['address'] = $obj['address'];
    $yt_sch[$i]['equipment'] = $eqp;
    $yt_sch[$i]['span'] = count($eqp);
    $yt_sch[$i]['month'] = $month;
    $y_sch[] = $yt_sch[$i];
    $month = [];
}
$y_sch = array_values($y_sch);
uasort($y_sch, 'sort_names');

$coun = 1;
