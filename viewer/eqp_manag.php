<?php
include_once 'header.php';
if ($auth && $_SESSION['login'] == 'admin') {
    include_once '../controller/cont_eqp_manag.php';
    if (empty($_GET['obj'])) {
        ?>
        <p class="manag_title">Выберите объект:</p>
        <div class="spisok">
            <?php foreach ($objs as $os) { ?>
                <p class="manag_Record"><a href="?obj=<?= $os['id'] ?>"><?= $os['name'] ?></a></p>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p><a class="another" href="./eqp_manag.php">< Выбрать другой объект</a></p>
        <div class="obj_title"><?= $name ?></div>
        <table class="eqp">
            <tr>
                <th>Тип</th>
                <th>Наименование</th>
                <th>Короткое наименование</th>
                <th>Категория</th>
                <th>Количество</th>
                <th>Операции</th>
            </tr>
            <?php foreach ($eq as $e) { ?>
                    <tr class="manag_record">
                        <form onsubmit="are_you_sure(this);return false;" action="" method="post">
                        <td><form action="" method="post"><input class="eqp_type" type="text" name="eqp_type" value="<?= $e['type'] ?>"></td>
                        <td><input class="eqp_name" type="text" name="eqp_name" value='<?= $e['name'] ?>'></td>
                        <td><input class="eqp_short_name" type="text" name="eqp_short_name" value='<?= $e['short_name'] ?>'></td>
                        <td><input class="eqp_cat" type="text" name="eqp_cat" value="<?= $e['category'] ?>"></td>
                        <td><input class="eqp_qty" type="text" name="eqp_qty" value="<?= $e['quantity'] ?>"></td>
                        <td>
                            <input type="hidden" value="<?= $e['id'] ?>" name="eqp_id">
                            <input type="submit" value="Изменить" name="submit">
                            <input type="submit" value="Удалить" name="submit">
                        </td>
                        </form>
                    </tr>
                <?php } ?>
                <tr><td><br><br></td></tr>
                    <tr>
                        <th>Тип</th>
                        <th>Наименование</th>
                        <th>Короткое наименование</th>
                        <th>Категория</th>
                        <th>Количество</th>
                        <th></th>
                    </tr>
                    <tr class="manag_record">
                        <form action="" method="post">
                        <td><input class="eqp_type" type="text" name="eqp_type"></td>
                        <td><input class="eqp_name" type="text" name="eqp_name"></td>
                        <td><input class="eqp_short_name" type="text" name="eqp_short_name"></td>
                        <td><input class="eqp_cat" type="text" name="eqp_cat"></td>
                        <td><input class="eqp_qty" type="text" name="eqp_qty"></td>
                        <td><input name="submit" type="submit" value="Добавить"></td>
                        </form>
                    </tr>
            </form>
        </table>
        <?php
    }
}
include_once 'footer.php';
?>
