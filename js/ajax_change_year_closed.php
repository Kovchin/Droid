<?php

session_id($_POST['sess']);
session_start();
if ($_SESSION['auth'] == 1 && $_SESSION['login'] == 'admin') {
    include_once '../model/properties_class.php';
    include_once '../model/database_class.php';
    $change = new database;

    $change->update('year_close', 'close', $_POST['data'], 'id', '1');
}