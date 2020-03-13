<?php
include_once 'header.php';
if ($auth && $_SESSION['login'] == 'admin') {
    include_once '../controller/cont_service.php';
    ?>
    <p>
        <input onclick="change_year_closed()" type="button" name="year_close" value="">
    </p>
    <p id="range">Показать изменения с 
        <input onchange="show_range_log()" type="date" name="start_date" value="<?= $_COOKIE['start_date'] ?>"> по 
        <input onchange="show_range_log()" type="date" name="end_date" value="<?= $_COOKIE['end_date'] ?>">
    </p>
    <div id="log"></div>
    <script type="text/javascript">
        $(document).ready(function () {
            get_year_closed();
            show_range_log();
        });
    </script>
    <?php
}
include_once 'footer.php';
?>