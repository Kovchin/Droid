<?php
include_once 'header.php';
include_once '../controller/cont_build_year.php';
?>
<?php if (empty($_GET['hide'])) { ?>
    <p class="choose">График за
    <select onchange="new_year()" name="year">
        <?php foreach ($year_list as $y) { ?>
            <option value="<?= $y[0] ?>"<?= $y[1] ?>><?= $y[0] ?></option>
        <?php } ?>
    </select>
    <p>
    <p class="choose"><a href="?hide=1">Скрыть меню</a></p>
    <div class="download"><a target="_blank" href="./build_year_save.php">Скачать график</a></div>
<?php } ?>
<table border="1" class="month">
    <tr>
        <th rowspan="2">№</th>
        <th rowspan="2">Наименование СУД</th>
        <th rowspan="2">Расположение</th>
        <th rowspan="2">Состав СУД</th>
        <th rowspan="2">Кол-во</th>
        <th colspan="12">месяцы</th>
    </tr>
    <tr>
        <?php for ($m = 1; $m <= 12; $m++) { ?>
            <th><?php echo sprintf('%02d', $m); ?></th>
        <?php } ?>
    </tr>
    <?php
    foreach ($y_sch as $s) {
        if (fmod($coun, 2) == 0) {
            $shad = 'shad';
        } else
            $shad = ''
            ?>
        <tr class="<?= $shad ?>">
            <td class="bold center" rowspan = "<?= $s['span'] ?>"><?= $coun ?></td>
            <td class="bold" rowspan = "<?= $s['span'] ?>"><?= $s['name'] ?></td>
            <td rowspan = "<?= $s['span'] ?>"><?= $s['address'] ?></td>
            <td><?= $s['equipment'][0]['type'] . ' ' . $s['equipment'][0]['name'] ?></td>
            <td class="center"><?= $s['equipment'][0]['quantity'] ?></td>
            <?php for ($m = 1; $m <= 12; $m++) { ?>
                <td rowspan = "<?= $s['span'] ?>">
                    <?php if (in_array($m, $s['month'])) echo 'X' ?>
                </td>
            <?php } ?>
        </tr>
        <?php for ($i = 1; $i < count($s['equipment']); $i++) { ?>
            <tr class="<?= $shad ?>">
                <td><?= $s['equipment'][$i]['type'] . ' ' . $s['equipment'][$i]['name'] ?></td>
                <td class="center"><?= $s['equipment'][$i]['quantity'] ?></td>
            </tr>
        <?php } ?>
        <?php $coun++;
    }
    ?>
</table>
<?php
if (empty($_GET['hide'])) {
    include_once 'footer.php';
}
?>
