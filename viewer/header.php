<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Список объектов</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="Список объектов" />
        <meta name="viewport" content="width=device-width; initial-scale=1">
        <link type="text/css" rel="stylesheet" href="../css/main.css" />
        <script src="../js/jquery.js"></script>
        <script src="../js/functions.js" defer></script>
    </head>
    <body width="1000px">
        <?php
        include_once '../controller/menu.php';
        if (empty($_GET['hide'])) {
            ?>
            <!-- Меню начало -->
            <div class="banner">
                <div class="menu_ERG">
                    <?php
                    if ($auth) {
                        if ($_SESSION['login'] == 'admin' || $_SESSION['login'] == 'ds') {
                            foreach ($erg_list as $erg) {
                                $act = '';
                                if ($_COOKIE['erg_id'] == $erg['id']) {
                                    $act = 'active';
                                }
                                ?>
                                <a class="<?= $act ?>" href="?erg=<?= $erg['id'] ?>"><?= $erg['name'] ?></a>
                                <?php
                            }
                            if ($_COOKIE['erg_id'] == 'all') {
                                $act_all = 'active';
                            }
                            ?>
                            <a class="<?= $act_all ?>" href="?erg=all">Все</a>
                        <?php }
                    }
                    ?>
                    <span class="login">
                        <form action="" method="post">
    <?php if (!$auth) { ?> 
                                Логин: &nbsp;<input type="text" name="login">
                                Пароль: <input type="password" name="pass">
                                <input type="submit" name="submit" value="Войти">
                            <?php
                            } else {
                                echo 'Добро пожаловать, ' . $name;
                                ?>
                                <input type="submit" name="submit" value="Выйти">
    <?php } ?>
                            <span style="color: red"><?= $notice ?></span>
                        </form>
                    </span>
                </div>
                <div class="logo">
                    <p>ОТС Сибири Droid</p>
                </div>
                <p class="instruction"><a href="https://www.youtube.com/watch?v=c6ab7QSLxvM&feature=youtu.be" target="_blank">Видеоинструкция</a></p>
    <?php if ($auth && ($_SESSION['login'] == 'admin' || $_SESSION['login'] == 'ds')) { ?>
                    <div class="menu_Manage">
                        <ul>
                            <li>Админ-панель</li>
        <?php if ($_SESSION['login'] == 'admin') { ?>
                                <li><a href="erg_manag.php">Управление ЭРГ</a></li>
                                <li><a href="obj_manag.php">Управление объектами</a></li>
                                <li><a href="eqp_manag.php">Управление оборудованием</a></li>
                                <li><a href="signs_manag.php">Управление подписями</a></li>
                                <li><a href="service.php">Служебные</a></li>
        <?php } ?>
                            <li><a href="reports.php">Работы на сегодня</a></li>
                        </ul>
                    </div>
    <?php } ?>
            </div>
            <div class="schedule">
                <a href="build_month.php">График месячный</a>
                <a href="schedule.php">Редактировать</a>
                <div class="blank"></div>
                <a href="build_year.php">График годовой</a>
                <a href="schedule_year.php">Редактировать</a> 
            </div>
            <!-- Меню конец -->  
            <?php
            if (!$auth)
                exit();
        }
        ?>