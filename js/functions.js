$(document).ready(function() {
    //ajax();
});

function change_date(date, id, previous) { 
    var sess = getCookie('PHPSESSID');
    $.ajax({
        url: '../../js/ajax_change_date.php',
        type: "POST",
        data: {date: date, id: id, previous: previous, sess: sess},
        dataType: "text",
        error: error,
    });
}

function change_year_schedule(data) {
    var sess = getCookie('PHPSESSID');
    var year = getCookie('year');
    $.ajax({
        url: '../../js/ajax_change_year_schedule.php',
        type: "POST",
        data: {data: data, year: year, sess: sess},
        dataType: "text",
        error: error,
        success: show_year
    });
}

function new_month() {
    var m = $('[name="month"]')[0].value;
    var y = $('[name="year"]')[0].value;
    document.cookie = "month=" + m;
    document.cookie = "m_year=" + y;
    location.reload();
}

function new_year() {
    var y = $('[name="year"]')[0].value;
    document.cookie = "year=" + y;
    location.reload();
}

function show_year() {
    var year = getCookie('year');
    var erg_id = getCookie('erg_id');
    var sess = getCookie('PHPSESSID');
    $.ajax({
        url: '../../js/ajax_show_year.php',
        type: "POST",
        data: {year: year, erg_id: erg_id, sess: sess},
        dataType: "text",
        error: error,
        success: show_table,
    });
}

function status_change(id, checked) {
    if(checked == true) {
        checked = 1;
    } else if(checked == false) {
        checked = 0;
    }
    var sess = getCookie('PHPSESSID');
    $.ajax({
        url: '../../js/ajax_status_change.php',
        type: "POST",
        data: {id: id, checked: checked, sess: sess},
        dataType: "text",
        error: error,
    });
    show_report();
}

function show_report() {
    var cur_date = $('input[name="cur_date"]')[0].value;
    var sess = getCookie('PHPSESSID');
    $.ajax({
        url: '../../js/ajax_reports.php',
        type: "POST",
        data: {cur_date: cur_date, sess: sess},
        dataType: "text",
        error: error,
        success: build_report,
    });
}

function build_report(result) {
    $('#report').html(result);
}

function show_range_log() {
    var start_date = $('#range input')[0].value;
    var end_date = $('#range input')[1].value;
    document.cookie = "start_date=" + start_date;
    document.cookie = "end_date=" + end_date;
    var sess = getCookie('PHPSESSID');
    $.ajax({
        url: '../../js/ajax_log.php',
        type: "POST",
        data: {
            start_date: start_date, 
            end_date: end_date, 
            sess: sess
        },
        dataType: "text",
        error: error,
        success: show_log,
    });
}

function get_year_closed() {
    $.ajax({
        url: '../../js/ajax_is_year_closed.php',
        dataType: "text",
        error: error,
        success: is_year_closed,
    });
}

function change_year_closed() {
    if($('input[name="year_close"]')[0].value == 'Закрыть редактирование годового графика') {
        var data = 1;
        $('input[name="year_close"]')[0].value = 'Открыть редактирование годового графика';
    } else if($('input[name="year_close"]')[0].value == 'Открыть редактирование годового графика') {
        var data = 0;
        $('input[name="year_close"]')[0].value = 'Закрыть редактирование годового графика';
    }
    var sess = getCookie('PHPSESSID');
    $.ajax({
        url: '../../js/ajax_change_year_closed.php',
        type: "POST",
        data: {
            data: data, 
            sess: sess
        },
        dataType: "text",
        error: error,
    });
    
}

function is_year_closed(result) {
    if(result == 0) {
        $('input[name="year_close"]')[0].value = 'Закрыть редактирование годового графика';
    }
    if(result == 1) {
        $('input[name="year_close"]')[0].value = 'Открыть редактирование годового графика';
    }
}

function error() {
    alert('Ошибка при загрузке данных!');
}

function show_table(result) {
    $('#main_table').html(result);
}

function show_log(result) {
    $('#log').html(result);
}

function getCookie(name) {
  var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

function are_you_sure(f) {
    if (confirm("Вы уверены, что хотите внести эти изменения?\nЭта операция не восстановима."))
        f.submit();
}

//Функция считывающая количество объектов и в зависимости от желаемого количества колонок рассчитывает количество записей (используется в )
function set_columns_eqp_manag(MyColumns){
    var MyRows = Math.ceil($(".spisok p").length/MyColumns);
    $(".spisok").css("grid-template-columns", "repeat(" + MyColumns +", 1fr)");
    $(".spisok").css("grid-template-rows", "repeat(" + MyRows +", 1fr)");
}

set_columns_eqp_manag(4);