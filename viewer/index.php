<?php

include_once "../model/properties_class.php";
include_once "../model/database_class.php";

$a = new database;

$file = fopen('2019.csv', 'r');
$i = 1;
while($f = fgetcsv($file, 0, ';')) {
    $id = $a->select_cols_where('objects', ['id', 'erg_id'], 'name', $f[0]);
    $erg_id = trim($id['erg_id']);
    $id = trim($id['id']);
    echo $i.': ';
    print_r($erg_id);
    echo '<br>';
    //$a->insert('sch_year', [['obj_id', 'erg_id', 'month', 'year'], [$id, $erg_id, trim($f[1]), '2019']]);
    //$a->insert('sch_year', [['obj_id', 'erg_id', 'month', 'year'], [$id, $erg_id, trim($f[2]), '2019']]);
    //$a->insert('sch_year', [['obj_id', 'erg_id', 'month', 'year'], [$id, $erg_id, trim($f[3]), '2019']]);
    //$a->insert('sch_year', [['obj_id', 'erg_id', 'month', 'year'], [$id, $erg_id, trim($f[4]), '2019']]);
    $i++;
}