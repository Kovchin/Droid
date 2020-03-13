<?php
include_once 'header.php';
include_once '../controller/cont_schedule.php';
?>
<p class="choose">График за
    <select onchange="new_month()" name="month">
        <?php foreach ($months as $m) { ?>
            <option value="<?= $m[0] ?>"
            <?php if ($_COOKIE['month'] == $m[0]) echo ' selected'; ?>
                    ><?= $m[1] ?></option>
                <?php } ?>
    </select>
    <select onchange="new_month()" name="year">
        <?php foreach ($year_list as $y) { ?>
            <option value="<?= $y[0] ?>"<?= $y[1] ?>><?= $y[0] ?></option>
        <?php } ?>
    </select>
</p>
<table class="edit_month">
    <tr>
        <th><a href="?">№</a></th>
        <th><a href="?sort=name">Наименование объекта</a></th>
        <th><a href="?sort=day">Дата</a></th>
    </tr>
    <?php
    foreach ($sch as $s) {
        $check = '';
        $status = '';
        if ($s['date'] == '') {
            $check = '<td class="check">Не заполнено поле!</td>';
        }
        $time = time();
        $check_date = strtotime($s['date']) + 86400;
        if ($time > $check_date && $s['date'] != '' && $s['status'] == 0) {
            $status = '<td class="check">Работы не были выполнены!</td>';
        }
        ?>
        <tr>
            <td><?= $coun ?></td>
            <td><?= $s['obj_id'] ?></td>
            <td>
                <input onchange="change_date(this.value, <?= $s['id'] ?>, this.defaultValue)" type="date" value="<?= $s['date'] ?>" name="date" 
                       min="<?= $_COOKIE['m_year'] ?>-<?= sprintf('%02d', $_COOKIE['month']) ?>-01" 
                       max="<?= $_COOKIE['m_year'] ?>-<?= sprintf('%02d', $_COOKIE['month']) ?>-<?= $max_m ?>"<?= $s['disabled'] ?>>
            </td>
    <?= $check ?>
    <?= $status ?>
        </tr>
        <?php
        $coun ++;
    }
    ?>
</table>
<?php
include_once 'footer.php';
?>
