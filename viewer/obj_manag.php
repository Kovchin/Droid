<?php
include_once 'header.php';
if ($auth && $_SESSION['login'] == 'admin') {
    include_once '../controller/cont_obj_manag.php';
    ?>
    <table class="obj_manag">
        <form action="" method="post">
            <tr class="manag_title">
                <th></th>
                <th>Наименование объекта</th>
                <th>Адрес</th>
                <th>ЭРГ</th>
                <th></th>
            </tr>
            <tr class="manag_record">
                <td></td>
                <td><input class="obj_name" type="text" name="obj_name"></td>
                <td><input class="obj_address" type="text" name="obj_addr"></td>
                <td><select name="erg_id" class="manag_record">
                        <?php
                        foreach ($erg_list as $erg) {
                            $select = '';
                            if ($_COOKIE['erg_id'] == $erg['id']) {
                                $select = ' selected';
                            }
                            ?>
                            <option value="<?= $erg['id'] ?>"<?= $select ?>><?= $erg['name'] ?></option>
    <?php } ?>
                    </select></td>
                <td><input name="submit" type="submit" value="Добавить"></td>
            </tr>
            <tr><td><br></td></tr>
        </form>
        <tr class="manag_title">
            <th>ID</th>
            <th>Наименование объекта</th>
            <th>Адрес</th>
            <th>ЭРГ</th>
            <th>Операции</th>
        </tr>
    <?php foreach ($objs as $os) { ?>
            <tr class="manag_record">
            <form onsubmit="are_you_sure(this);return false;" action="" method="post">
                <input type="hidden" name="obj_id_old" value="<?= $os['id'] ?>">
                <td><input class="obj_id" type="text" name="obj_id_new" value="<?= $os['id'] ?>"></td>
                <td><input class="obj_name" type="text" name="obj_name" value='<?= $os['name'] ?>'></td>
                <td><input class="obj_address"type="text" name="obj_addr" value='<?= $os['address'] ?>'></td>
                <td>
                    <select name="erg_id" class="manag_record">
                        <?php
                        foreach ($erg_list as $erg) {
                            $sel = '';
                            if ($erg['id'] == $os['erg_id'])
                                $sel = 'selected ';
                            ?>
                            <option <?= $sel ?>value="<?= $erg['id'] ?>"><?= $erg['name'] ?></option>
        <?php } ?>
                    </select>
                </td>
                <td>
                    <input type="submit" value="Изменить" name="submit">
                    <input type="submit" value="Удалить" name="submit">
                </td>
            </form>
        </tr>
    <?php } ?>
    </table>
    <?php
}
include_once 'footer.php';
?>
