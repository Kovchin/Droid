<?php

// Name: schedule editor
session_id($_POST['sess']);
session_start();
if ($_SESSION['auth'] == 1) {
    include_once '../model/properties_class.php';
    include_once '../model/database_class.php';
    $log = new database;
    $start = strtotime($_POST['start_date']);
    $end = strtotime($_POST['end_date']) + 84600;
    
    $res = $log->select_cols_range('log', ['note'], 'time', $start, $end, 1);
}
?>

<table>
    <tr>
        <th>
            LOG
        </th>
    </tr>
    <?php foreach ($res as $r) { ?>
    <tr>
        <td>
            <?= $r['note'] ?>
        </td>
    </tr>
    <?php } ?>
</table>