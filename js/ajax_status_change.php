<?php
// Name: schedule editor
session_id($_POST['sess']);
session_start();
if ($_SESSION['auth'] == 1 && ($_SESSION['login'] == 'admin' || $_SESSION['login'] == 'ds')) {
    include_once '../model/properties_class.php';
    include_once '../model/database_class.php';
    $reports = new database;
    $reports->update('schedule', 'status', $_POST['checked'], 'id', $_POST['id']);
}
?>