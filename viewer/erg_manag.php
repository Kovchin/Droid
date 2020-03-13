<?php
include_once 'header.php';
if ($auth && $_SESSION['login'] == 'admin') {
    include_once '../controller/cont_erg_manag.php';
    ?>

    <table class="erg">
        <tr class="manag_title">
            <th>ЭРГ</th>
            <th>Изменение</th>
            <th>Новый пароль</th>
            <th>Удаление</th>
        </tr>
        <?php foreach ($ergs as $es) { ?>
            <tr class="manag_record">
            <form onsubmit="are_you_sure(this);return false;" action="" method="post">
                <td><input type="text" name="erg_upd" value="<?= $es['name'] ?>"></td>
                <td>
                    <input type="submit" value="Изменить" name="submit">
                </td>
                <td class="pass_change" >
                    <input type="text" name="new_login" value="<?= $es['login'] ?>">
                    <input type="password" name="new_pass">
                    <input type="submit" value="Сбросить" name="submit">
                </td>
                <td>
                    <input type="submit" value="Удалить" name="submit">
                    <input type="hidden" name="erg_id" value="<?= $es['id'] ?>" >
                </td>
            </form>
        </tr>
    <?php } ?>
    <form class="erg" action="" method="post">
        <tr>
            <td><input type="text" name="erg_name" class="manag_record" required></td>
            <td><input name="submit" type="submit" class="manag_record" value="Добавить"></td>
        </tr>
    </form>
    </table>
    <?php
}
include_once 'footer.php';
?>
