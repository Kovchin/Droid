<?php
include_once 'header.php';
include_once '../controller/cont_schedule_year.php';
?>
<form action="" method="post">
    <p class="choose">График за
        <select onchange="new_year()" name="year">
            <?php foreach ($year_list as $y) { ?>
                <option value="<?= $y[0] ?>"<?= $y[1] ?>><?= $y[0] ?></option>
            <?php } ?>
        </select>
        год
    <p>
</form>
<div id="main_table">

</div>
<script type="text/javascript">
    $(document).ready(function () {
        show_year();
    });
</script>
<?php
include_once 'footer.php';
?>
