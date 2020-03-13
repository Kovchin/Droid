<?php

// main menu controller

include_once '../controller/include_classes.php';

$menu_sch = new database;
$erg_list = $menu_sch->select_all('erg');

//echo var_dump($erg_list);

// Обработка формы авторизации
session_set_cookie_params(5184000);
session_start();

$notice = '';
$_SESSION['auth'] = 0;
$auth = false;
$error = false;
$admin = ['login' => 'admin', 'pass' => '04e06867b28db255563bdda76694a73b'];
$ds = ['login' => 'ds', 'pass' => '3172a7a3ee6469fb5eb31130c3535f23'];

$mass = $menu_sch->select_columns_all('erg', ['login', 'pass']);
$mass[] = $admin;
$mass[] = $ds;

if (isset($_POST['submit'])) {
    if ($_POST['submit'] == 'Войти') {
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['pass'] = md5($_POST['pass']);
        $error = true;
    } elseif ($_POST['submit'] == 'Выйти') {
        unset($_SESSION['login']);
        unset($_SESSION['pass']);
    }
}

$iss = isset($_SESSION['login']) && isset($_SESSION['pass']);

if ($iss && in_array(['login' => $_SESSION['login'], 'pass' => $_SESSION['pass']], $mass)) {
    $auth = true;
    $error = false;
    $_SESSION['auth'] = 1;
    if ($_SESSION['login'] == 'admin') {
        $name = 'Администратор';
        unset($_SESSION['erg_id']);
    } elseif($_SESSION['login'] == 'ds') {
        $name = 'Дежурный специалист';
        unset($_SESSION['erg_id']);
    } else {
        $name = $menu_sch->select_cols_where('erg', ['name'], 'login', $_SESSION['login']);
        $name = $name['name'];
        $temp_erg_id = $menu_sch->select_cols_where('erg', ['id'], 'login', $_SESSION['login']);
        $_SESSION['erg_id'] = $temp_erg_id['id'];
        setcookie('erg_id', $temp_erg_id['id']);
    }
}

if ($error) {
    $notice = 'Вы ввели неверный логин и/или пароль';
}

//Конец обработки авторизации


if (isset($_GET['erg'])) {
    if ($auth) {
        if ($_SESSION['login'] == 'admin' || $_SESSION['login'] == 'ds') {
            setcookie('erg_id', $_GET['erg']);
            if ($_GET['erg'] != $_COOKIE['erg_id']) {
                header('Location: ' . $_SERVER['PHP_SELF']);
            }
        } else {
            setcookie('erg_id', $_SESSION['erg_id']);
        }
    }
}

$cur_year = date('Y', time());
$cur_month = date('m', time());

if (
        empty($_COOKIE['m_year']) ||
        empty($_COOKIE['month']) ||
        empty($_COOKIE['erg_id']) ||
        empty($_COOKIE['year'])
) {
    if (empty($_COOKIE['month'])) {
        setcookie('month', $cur_month);
    }
    if (empty($_COOKIE['m_year'])) {
        setcookie('m_year', $cur_year);
    }
    if (empty($_COOKIE['erg_id'])) {
        if (isset($_SESSION['erg_id'])) {
            setcookie('erg_id', $_SESSION['erg_id']);
        } else
            setcookie('erg_id', 'all');
    }
    if (empty($_COOKIE['year'])) {
        setcookie('year', $cur_year + 1);
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
}

function showAll($string) {
    echo '<pre>';
    print_r($string);
    echo '</pre>';
}
