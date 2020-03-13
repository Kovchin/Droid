<?php
// Name: schedule editor
session_id($_POST['sess']);
session_start();
if ($_SESSION['auth'] == 1) {
    include_once '../model/properties_class.php';
    include_once '../model/database_class.php';
    $reports = new database;
    $cur_date = strtotime($_POST['cur_date']);
    $day = date('j', $cur_date);
    $month = date('n', $cur_date);
    $year = date('Y', $cur_date);
    $ergs = $reports->select_columns_all('erg', ['id', 'name']);

    for ($k = 0; $k < count($ergs); $k++) {
        $ergs[$k]['obj'] = $reports->select_multi_where('schedule', 
                ['day', 'month', 'year', 'erg_id'], 
                [$day, $month, $year, $ergs[$k]['id']], 
                1);
        for($i = 0; $i < count($ergs[$k]['obj']); $i++) {
            $obj = $reports->select_cols_where('objects', ['name'], 'id', $ergs[$k]['obj'][$i]['obj_id']);
            $ergs[$k]['obj'][$i]['obj_id'] = $obj['name'];
        }
    }
}
?>

<table class="reports">
    <tr>
        <th>
            Плановые работы
        </th>
        <th>Статус</th>
    </tr>
<?php foreach ($ergs as $erg) { ?>
        <tr>
            <td class="erg_name"><?= $erg['name'] ?></td>
        </tr>
        <?php foreach($erg['obj'] as $er) { 
            $chk = '';
            $class = 'no';
            if($er['status'] == 1) {
                $chk = ' checked';
                $class = 'yes';
            }
            ?>
        <tr class="<?= $class ?> highlight">
            <td class="reports"><?= $er['obj_id'] ?></td>
            <td class="rep_check">
                <input onchange="status_change(this.value, this.checked)" name="status" type="checkbox" value="<?= $er['id'] ?>"<?= $chk ?>>
            </td>
        </tr>
        <?php } ?>
            <?php } ?>
</table>
<script type="text/javascript">
    console.log($('input[name="status"]')[0]);
</script>