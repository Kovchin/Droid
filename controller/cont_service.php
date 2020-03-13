<?php

// Name: schedule editor

include_once '../controller/menu.php';

if(empty($_COOKIE['start_date'])) {
    $_COOKIE['start_date'] = date('Y-m-d', time() - 604800);
}

if(empty($_COOKIE['end_date'])) {
    $_COOKIE['end_date'] = date('Y-m-d', time());
}

