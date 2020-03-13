<?php
// Name: schedule editor
include_once '../model/properties_class.php';
include_once '../model/database_class.php';
session_id($_POST['sess']);
session_start();
function sort_erg_id($a, $b) {
    if ($a['erg_id'] == $b['erg_id']) {
        return 0;
    }
    return ($a['erg_id'] < $b['erg_id']) ? -1 : 1;
}

function sort_obj_id($a, $b) {
    if ($a['obj_id'] == $b['obj_id']) {
        if ($a['id'] == 0) {
            return -1;
        }
        if ($b['id'] == 0) {
            return 1;
        }
    }
    return ($a['obj_id'] < $b['obj_id']) ? -1 : 1;
}

$year = new database;

$cur_year = date('Y', time());

if ($_POST['erg_id'] == 'all') {
    $sch = $year->select_multi_where('schedule', ['year'], [$_POST['year']], 1);
    $sch_temp = $year->select_columns_all('objects', ['id', 'erg_id']);
} else {
    $sch = $year->select_multi_where('schedule', ['erg_id', 'year'], [$_POST['erg_id'], $_POST['year']], 1);
    $sch_temp = $year->select_cols_where('objects', ['id', 'erg_id'], 'erg_id', $_POST['erg_id'], 1);
}

$temp_list = [];
foreach ($sch_temp as $st) {
    $temp_list[] = [
        'id' => 0,
        'obj_id' => $st['id'],
        'erg_id' => $st['erg_id'],
        'day' => 0,
        'month' => 0,
        'year' => $_POST['year'],
    ];
}
$sch = array_merge($sch, $temp_list);
uasort($sch, 'sort_obj_id');
$sch = array_values($sch);

$y_sch = [];

for ($i = 0; $i < count($sch); $i++) {
    if ($i != count($sch) - 1) {
        if ($sch[$i]['obj_id'] == $sch[$i + 1]['obj_id']) {
            $month[] = $sch[$i]['month'];
            $id[] = $sch[$i]['id'];
            continue;
        }
    }
    $month[] = $sch[$i]['month'];
    $id[] = $sch[$i]['id'];
    $obj = $year->select_cols_where('objects', ['name'], 'id', $sch[$i]['obj_id']);
    $sch[$i]['name'] = $obj['name'];
    $sch[$i]['month'] = [];
    $sch[$i]['id'] = [];
    for ($m = 1; $m <= 12; $m++) {
        $sch[$i]['month'][$m] = 0;
        $sch[$i]['id'][$m] = 0;
        for ($k = 0; $k < count($month); $k++) {
            if ($m == $month[$k]) {
                $sch[$i]['month'][$m] = 1;
                $sch[$i]['id'][$m] = $id[$k];
            }
        }
    }
    $y_sch[] = $sch[$i];
    $id = [];
    $month = [];
}
uasort($y_sch, 'sort_erg_id');

//Проверка на отключение редактирования годового графика
$disable = '';
$dis_status = $year->select_cols_where('year_close', ['close'], 'id', '1');
if($dis_status['close'] == 1 && $_SESSION['login'] != 'admin') {
        $disable = ' disabled';
}

$coun = 1;
?>
<table class="year">
    <tr>
        <th rowspan="2">№</th>
        <th rowspan="2">Наименование объекта</th>
        <th class="small1_th" colspan="12">Месяц</th>
    </tr>
    <tr>
        <?php for ($m = 1; $m <= 12; $m++) { ?>
            <th  class="small2_th"><?= $m ?></th>
            <?php } ?>
    </tr>
    <?php foreach ($y_sch as $s) { ?>
        <tr>
            <td><?= $coun ?></td>
            <td><?= $s['name'] ?></td>
            <?php
            for ($m = 1; $m <= 12; $m++) {
                $checked = '';
                if ($s['month'][$m] == 1) {
                    $checked = ' checked';
                }
                $data = $s['id'][$m] . '_' . $s['obj_id'] . '_' . $s['erg_id'] . '_' . $m;
                ?>
                <td>
                    <input onchange="change_year_schedule(this.value)" type="checkbox" value="<?= $data ?>"<?= $checked ?><?= $disable ?>>
                </td>
            <?php } ?>
        </tr>
        <?php
        $coun++;
    }
    ?>
</table>
