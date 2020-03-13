<?php
include_once 'header.php';
if ($auth && ($_SESSION['login'] == 'admin' || $_SESSION['login'] == 'ds')) {
    include_once '../controller/cont_reports.php';
    ?>
    <p>Показать работы на  
        <input onchange="show_report()" type="date" name="cur_date" value="<?= $cur_date ?>">
    </p>
    <div id="report"></div>
    <script type="text/javascript">
        $(document).ready(function () {
            show_report();
        });
    </script>
    <?php
}
include_once 'footer.php';
?>