<?php

// Name: schedule editor
session_id($_POST['sess']);
session_start();
if ($_SESSION['auth'] == 1  && $_SESSION['login'] != 'ds') {
    include_once '../model/properties_class.php';
    include_once '../model/database_class.php';

    $sch = new database;
    $data = explode('_', $_POST['data']);
    $year = $_POST['year'];

    if ($data[0] == 0) {
        $sch->insert('schedule', [['obj_id', 'erg_id', 'month', 'year'], [$data[1], $data[2], $data[3], $year]]);
    } else {
        $sch->remove('schedule', 'id', $data[0]);
    }
}