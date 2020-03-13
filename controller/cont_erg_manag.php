<?php

// Name: erg editor

include_once '../controller/menu.php';

$erg_manag = new database;

$ergs = $erg_manag->select_all('erg');


// Processing pushed buttons
if(isset($_POST['submit'])) {
    if($_POST['submit'] == 'Добавить') {
        $erg_manag->insert('erg', [['name'], [$_POST['erg_name']]]);
        header("Location: ./erg_manag.php");
    } elseif($_POST['submit'] == 'Удалить') {
        $erg_manag->remove('erg', 'id', $_POST['erg_id']);
        header("Location: ./erg_manag.php");
    } elseif($_POST['submit'] == 'Изменить') {
        $erg_manag->update('erg', 'name', $_POST['erg_upd'], 'id', $_POST['erg_id']);
        header("Location: ./erg_manag.php");
    }  elseif($_POST['submit'] == 'Сбросить') {
        $erg_manag->multi_update('erg', ['login', 'pass'], [$_POST['new_login'], 
            md5($_POST['new_pass'])], 'id', $_POST['erg_id']);
        header("Location: ./erg_manag.php");
    }
}