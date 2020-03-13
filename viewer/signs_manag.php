<?php
include_once 'header.php';
if ($auth && $_SESSION['login'] == 'admin') {
    include_once '../controller/cont_signs_manag.php';
    ?>
    <form action="" method="post">
        <table class="signs">
            <tr class="manag_title">
                <th></th>
                <th>СОГЛАСОВАНО</th>
                <th>УТВЕРЖДАЮ</th>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="text" value='<?= $signs[0]['line1'] ?>' name="line1_1" class="manag_record">
                </td>
                <td>
                    <input type="text" value='<?= $signs[1]['line1'] ?>' name="line2_1" class="manag_record">
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="text" value='<?= $signs[0]['line2'] ?>' name="line1_2" class="manag_record">
                </td>
                <td>
                    <input type="text" value='<?= $signs[1]['line2'] ?>' name="line2_2" class="manag_record">
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="text" value='<?= $signs[0]['line3'] ?>' name="line1_3" class="manag_record">
                </td>
                <td>
                    <input type="text" value='<?= $signs[1]['line3'] ?>' name="line2_3" class="manag_record">
                </td>
            </tr>
            <tr>
                <td><b>Имя: </b></td>
                <td>
                    <input type="text" value='<?= $signs[0]['name'] ?>' name="line1_4" class="manag_record">
                </td>
                <td>
                    <input type="text" value='<?= $signs[1]['name'] ?>' name="line2_4" class="manag_record">
                </td>
            </tr>
        </table>
        <br><br>
        <p>Перечислите имена тех, кто ставит подписи через запятую:</p>
        <input class="wide_signs" type="text" value='<?= $signs[2]['line1'] ?>' name="line3" class="manag_record">
        <input name="submit" type="submit" class="manag_record" value="Изменить">
    </form>
    <?php
}
include_once 'footer.php';
?>
