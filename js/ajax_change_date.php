<?php

// Name: schedule editor
session_id($_POST['sess']);
session_start();
if ($_SESSION['auth'] == 1 && $_SESSION['login'] != 'ds') {
    include_once '../model/properties_class.php';
    include_once '../model/database_class.php';
    $schedule = new database;

    $current = strtotime($_POST['date']);
    $day = date('j', $current);

    if ($_SESSION['login'] != 'admin') {
        $previous = date('01-m-Y', $current);
        $previous = strtotime($current);
        $change_time = time();
        
        //39 дней = 3369600 с
        if ($change_time + 3369600 > $previous) {
            $obj = $schedule->select_where('schedule', 'id', $_POST['id']);
            $obj = $schedule->select_cols_where('objects', ['name'], 'id', $obj['obj_id']);
            $obj = $obj['name'];
            $name = $schedule->select_cols_where('erg', ['name'], 'login', $_SESSION['login']);
            $name = $name['name'];
            
            if ($_POST['previous'] != '') {
            $log = $name . ' изменил дату проведения ТО ' . $obj . ' с ' . $_POST['previous'] . ' на ' . $_POST['date'];
            $schedule->insert('log', [['note', 'time'], [$log, $change_time]]);
            }
        }
    }
    $schedule->update('schedule', 'day', $day, 'id', $_POST['id']);
}