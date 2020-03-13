<?php

// Name: schedule editor

include_once '../controller/menu.php';

function sort_date($a, $b) {
    if ($a['erg_id'] == $b['erg_id']) {
        if ($a['day'] == $b['day']) {
            if ($a['name'] == $b['name']) {
                return 0;
            }
            return ($a['name'] < $b['name']) ? -1 : 1;
        }
        return ($a['day'] < $b['day']) ? -1 : 1;
    }
    return ($a['erg_id'] < $b['erg_id']) ? -1 : 1;
}

$month = new database;
$sign_data = $month->select_all('signs');

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


//Year determination

$check_year = $cur_year - 2;
$year_list = [];
for($i = 0; $i < 6; $i++, $check_year++) {
    $year_list[$i][0] = $check_year;
    $year_list[$i][1] = '';
    if($check_year == $_COOKIE['m_year']) {
        $year_list[$i][1] = ' selected';
    }
}

// Processing pushed buttons
if(isset($_POST['submit'])) {
    setcookie('m_year', $_POST['year']);
    setcookie('month', $_POST['month']);
    header("Location: ./build_month.php");
}

if ($_COOKIE['erg_id'] == 'all') {
    $erg_sign = 1;
    $m_sch = $month->select_multi_where('schedule', ['month', 'year'], [$_COOKIE['month'], $_COOKIE['m_year']], 1, 'erg_id');
} else {
    $erg_sign = 0;
    $m_sch = $month->select_multi_where('schedule', ['erg_id', 'month', 'year'], [$_COOKIE['erg_id'], $_COOKIE['month'], $_COOKIE['m_year']], 1, 'erg_id');
}

for ($i = 0; $i < count($m_sch); $i++) {
    $obj = $month->select_where('objects', 'id', $m_sch[$i]['obj_id']);
    $eqp = $month->select_cols_where('equipment', ['type', 'name', 'quantity'], 'object_id', $m_sch[$i]['obj_id'], 1);
    $m_sch[$i]['name'] = $obj['name'];
    $m_sch[$i]['address'] = $obj['address'];
    $m_sch[$i]['equipment'] = $eqp;
    $m_sch[$i]['span'] = count($eqp);
}
uasort($m_sch, 'sort_date');

switch($_COOKIE['month']) {
    case 1:
        $mth = 'Январь';
        break;
    case 2:
        $mth = 'Февраль';
        break;
    case 3:
        $mth = 'Март';
        break;
    case 4:
        $mth = 'Апрель';
        break;
    case 5:
        $mth = 'Май';
        break;
    case 6:
        $mth = 'Июнь';
        break;
    case 7:
        $mth = 'Июль';
        break;
    case 8:
        $mth = 'Август';
        break;
    case 9:
        $mth = 'Сентябрь';
        break;
    case 10:
        $mth = 'Октябрь';
        break;
    case 11:
        $mth = 'Ноябрь';
        break;
    case 12:
        $mth = 'Декабрь';
        break;
        
}

$coun = 1;
