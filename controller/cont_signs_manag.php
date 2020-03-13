<?php

// Name: erg editor

include_once '../controller/menu.php';

$signs_manag = new database;

$signs = $signs_manag->select_all('signs');


// Processing pushed buttons
if(isset($_POST['submit']) && $_POST['submit'] == 'Изменить') {
    $signs_manag->update('signs', 'line1', $_POST['line1_1'], 'id', 1);
    $signs_manag->update('signs', 'line2', $_POST['line1_2'], 'id', 1);
    $signs_manag->update('signs', 'line3', $_POST['line1_3'], 'id', 1);
    $signs_manag->update('signs', 'name', $_POST['line1_4'], 'id', 1);
    $signs_manag->update('signs', 'line1', $_POST['line2_1'], 'id', 2);
    $signs_manag->update('signs', 'line2', $_POST['line2_2'], 'id', 2);
    $signs_manag->update('signs', 'line3', $_POST['line2_3'], 'id', 2);
    $signs_manag->update('signs', 'name', $_POST['line2_4'], 'id', 2);
    $signs_manag->update('signs', 'line1', $_POST['line3'], 'id', 3);
    header("Location: ./signs_manag.php");
}