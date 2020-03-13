<?php

// Name: equipment editor

include_once '../controller/menu.php';

$eqp_manag = new database;

if($_COOKIE['erg_id'] == 'all') {
    $objs = $eqp_manag->select_columns_all('objects', ['id', 'name']);
} else {
    $objs = $eqp_manag->select_cols_where('objects', ['id', 'name'], 'erg_id', $_COOKIE['erg_id'], 1);
}

if(isset($_GET['obj'])) {
    $eq = $eqp_manag->select_where('equipment', 'object_id', $_GET['obj'], 1);
    $name = $eqp_manag->select_cols_where('objects', ['name'], 'id', $_GET['obj']);
    $name = $name['name'];
}

// Processing pushed buttons
if(isset($_POST['submit'])) {
    if($_POST['submit'] == 'Добавить') {
        $eqp_manag->insert('equipment', 
                [[
                    'object_id', 
                    'type', 
                    'name',  
                    'short_name', 
                    'category', 
                    'quantity'], 
            [
                $_GET['obj'], 
                $_POST['eqp_type'], 
                $_POST['eqp_name'], 
                $_POST['eqp_short_name'], 
                $_POST['eqp_cat'], 
                $_POST['eqp_qty']]]);
        header('Location: '.$_SERVER['PHP_SELF'].'?obj='.$_GET['obj']);
    } elseif($_POST['submit'] == 'Удалить') {
        $eqp_manag->remove('equipment', 'id', $_POST['eqp_id']);
        header('Location: '.$_SERVER['PHP_SELF'].'?obj='.$_GET['obj']);
    } elseif($_POST['submit'] == 'Изменить') {
        $eqp_manag->multi_update('equipment', 
                [
                    'type', 
                    'name', 
                    'short_name',
                    'category',
                    'quantity'
                ],[
                    $_POST['eqp_type'], 
                    $_POST['eqp_name'], 
                    $_POST['eqp_short_name'], 
                    $_POST['eqp_cat'], 
                    $_POST['eqp_qty']],
                'id', $_POST['eqp_id']);
       header('Location: '.$_SERVER['PHP_SELF'].'?obj='.$_GET['obj']);
    }  
}