<?php

// Name: object editor

include_once '../controller/menu.php';

$obj_manag = new database;

if($_COOKIE['erg_id'] == 'all') {
    $objs = $obj_manag->select_all('objects');
} else {
    $objs = $obj_manag->select_where('objects', 'erg_id', $_COOKIE['erg_id'], 1);
}

$erg_list = $obj_manag->select_all('erg');

// Processing pushed buttons
if(isset($_POST['submit'])) {
    if($_POST['submit'] == 'Добавить') {
        $obj_manag->insert('objects', [['name', 'address', 'erg_id'], 
            [$_POST['obj_name'], $_POST['obj_addr'], $_POST['erg_id']]]);
        header("Location: ./obj_manag.php");
    } elseif($_POST['submit'] == 'Удалить') {
        $obj_manag->remove('objects', 'id', $_POST['obj_id_old']);
        $obj_manag->remove('equipment', 'object_id', $_POST['obj_id_old']);
        header("Location: ./obj_manag.php");
    } elseif($_POST['submit'] == 'Изменить') {
        $obj_manag->multi_update('objects', ['id', 'name', 'address', 'erg_id'],
                [$_POST['obj_id_new'], $_POST['obj_name'], $_POST['obj_addr'], $_POST['erg_id']],
                'id', $_POST['obj_id_old']);
        header("Location: ./obj_manag.php");
    }  
}