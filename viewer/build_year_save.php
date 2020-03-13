<?php 
include_once '../controller/cont_build_year.php';
include_once '../controller/tfpdf.php';

$pdf = new TFPDF();
$left_margin = 15;
$pdf->SetMargins($left_margin, 8); //Начальные отступы
$pdf->AddFont('times_new_roman','','times.ttf',true); //Обычный
$pdf->AddFont('times_new_roman_bd','','timesbd.ttf',true); //Жирный
$pdf->SetTitle($_COOKIE['year'], true);
$pdf->SetSubject('Годовой график ТО ОТС Сибири', 'true');
$pdf->SetKeywords('график ТО МУСЭ Сибири', 'true');
$pdf->SetAuthor('Шаян М.А.', 'true');
$pdf->SetCreator('OTS Sibiri Working Robot', 'true');
$pdf->AliasNbPages();

//Стандартные установки
$h = 6; // Высота строки
$pw = 266; //Ширина страницы(мм)
//Ширина колонок
$c1 = 6;
$c2 = 50;
$c3 = 54;
$c4 = 71;
$c5 = 13;
$c6 = 6;

$symbols = 30; //Максимальная длина строки адреса в символах

//Подписи
$bot_signs = $sign_data[2]['line1'];
$bot_signs = explode(',', $bot_signs);
for($i = 0; $i < count($bot_signs); $i++) {
    $bot_signs[$i] = trim($bot_signs[$i]);
}

$pdf->AddPage('L', 'A4');

$pdf->SetFont('times_new_roman_bd','', 12); //шрифт

$date = '"____" __________' . date('Y', time()) . 'г.'; //Место для подписи
$sign = '______________';

$top_left = [
    '"СОГЛАСОВАНО"', 
    $sign_data[0]['line1'], 
    $sign_data[0]['line2'], 
    $sign_data[0]['line3'], 
    $sign_data[0]['name']
    ];

$top_right = [
    '"УТВЕРЖДАЮ"', 
    $sign_data[1]['line1'], 
    $sign_data[1]['line2'], 
    $sign_data[1]['line3'], 
    $sign_data[1]['name']
    ];

// Вывод верхних подписей
$pdf->Cell($pw / 3, $h, $top_left[0], 0);
$pdf->Cell($pw / 3, $h, '', 0, '');
$pdf->Cell($pw / 3, $h, $top_right[0], 0, 1);
$pdf->Cell($pw / 3, $h, $top_left[1], 0);
$pdf->Cell($pw / 3, $h, '', 0, '');
$pdf->Cell($pw / 3, $h, $top_right[1], 0, 1);
$pdf->Cell($pw / 3, $h, $top_left[2], 0);
$pdf->Cell($pw / 3, $h, '', 0, '');
$pdf->Cell($pw / 3, $h, $top_right[2], 0, 1);
$pdf->Cell($pw / 3, $h, '', 0);
$pdf->Cell($pw / 3, $h, '', 0, '');
$pdf->Cell($pw / 3, $h, $top_right[3], 0, 1);
$pdf->Cell($pw / 3, $h, $sign.$top_left[4], 0);
$pdf->Cell($pw / 3, $h, '', 0, '');
$pdf->Cell($pw / 3, $h, $sign.$top_right[4], 0, 1);
$pdf->Cell($pw / 3, $h, $date, 0);
$pdf->Cell($pw / 3, $h, '', 0, '');
$pdf->Cell($pw / 3, $h, $date, 0, 1);

//Вывод заголовка
$pdf->SetFontSize(11);
$head = [
    'ПЛАН-ГРАФИК',
    'проведения профилактических работ на оборудовании СУД',
    'ЕТССЭ МЭС Сибири на ' . $_COOKIE['year'] . ' год'
    ];
$pdf->Cell($pw, $h, '', 0, 1);
$pdf->Cell($pw, $h, $head[0], 0, 1, 'C');
$pdf->Cell($pw, $h, $head[1], 0, 1, 'C');
$pdf->Cell($pw, $h, $head[2], 0, 1, 'C');

//Вывод шапки
$pdf->SetFillColor(180, 180, 150); //Цвет заливки темный
$pdf->SetFontSize(10);
$h = 4;

$th = [
    '№',
    'Наименование СУД',
    'Расположение',
    'Состав СУД',
    'Кол-во'
    ];

$pdf->Cell($c1, $h * 2, $th[0], 1, 0, 'C', 1);
$pdf->Cell($c2, $h * 2, $th[1], 1, 0, 'C', 1);
$pdf->Cell($c3, $h * 2, $th[2], 1, 0, 'C', 1);
$pdf->Cell($c4, $h * 2, $th[3], 1, 0, 'C', 1);
$pdf->Cell($c5, $h * 2, $th[4], 1, 0, 'C', 1);
$pdf->Cell($c6 * 12, $h, 'месяцы', 1, 2, 'C', 1);
for ($m = 1; $m <= 12; $m++) {
    $ln = 0;
    if($m == 12) $ln = 1;
    $pdf->Cell($c6, $h, "$m", 1, $ln, 'C', 1);
}


//График
$pdf->SetFont('times_new_roman');
$pdf->SetFillColor(230, 230, 220); //Цвет заливки светлый

$num_elements = count($y_sch);
$sign_height = $h * (round((count($bot_signs) / 2)) * 3 - 1);

foreach ($y_sch as $key => $s) {
        
    if(fmod($coun, 2) == 0) {
        $shad = 1;
    } else
        $shad = 0;    

    $addr = explode(' ', $s['address']);
    $j = 0;
    $i = 0;
    $r_addr = [];
    while ($i < count($addr)) {
        $r_addr[$j] = '';
        while ((mb_strlen($r_addr[$j]) + mb_strlen($addr[$i])) < $symbols) {
            $r_addr[$j] = $r_addr[$j] . ' ' . $addr[$i];
            $i++;
            if ($i >= count($addr)) {
                break;
            }
        }
        $j++;
    }
    
    $rows_eq = count($s['equipment']);
    $rows_addr = count($r_addr);
    $rows = max([$rows_eq, $rows_addr]);
    
    if($key == ($num_elements - 1) && ($pdf->GetY() + $sign_height + $h * $rows) > 189) {
        $pdf->AddPage('L', 'A4');
    }
    
    $pdf->Cell($c1, $h * $rows, $coun, 1, 0, 'C', $shad);
    $pdf->Cell($c2, $h * $rows, $s['name'], 1, 0, 'L', $shad);
    $tempY = $pdf->GetY();
    $tempX = $pdf->GetX();
    $pdf->Cell($c3, $h * $rows, '', 0, 0, '', $shad);
    $pdf->SetXY($left_margin + $c1 + $c2, $tempY + abs($h * ($rows - $rows_addr) / 2));
    foreach($r_addr as $r) {
         $pdf->Cell($c3, $h, $r, 0, 2, 'L', $shad);
    }
    $pdf->SetXY($tempX, $tempY);
    $pdf->Cell($c3, $h * $rows, '', 1);
    
    $pdf->SetXY($tempX + $c3, $tempY);
    
    if($rows_eq >= $rows_addr) {
        $h_eq = $h;
    } else {
        $h_eq = $rows_addr * $h / (count($s['equipment']));
    }
    
    foreach($s['equipment'] as $se) {
        $pdf->Cell($c4, $h_eq, $se['type'].' '.$se['name'], 1, 0, 'L', $shad);
        $pdf->Cell($c5, $h_eq, $se['quantity'], 1, 0, 'C', $shad);
        $pdf->SetXY($pdf->GetX() - $c4 - $c5, $pdf->GetY() + $h_eq);
    }
    $pdf->SetXY($pdf->GetX() + $c4 + $c5, $pdf->GetY() - $h * $rows);

    for ($m = 1; $m <= 12; $m++) {
        $ln = 0;
        if ($m == 12) $ln = 1;
        $c_date = '';
        if(in_array($m,$s['month'])) $c_date = 'X';
        $pdf->Cell($c6, $h * $rows, $c_date, 1, $ln, 'C', $shad);
    }

    $coun++;
}
$h = 6;
//Вывод нижних подписей
$pdf->SetFont('times_new_roman_bd','', 12); //шрифт
$pdf->Cell($pw, $h, '', 0, 1);

for($i = 0; $i < count($bot_signs); $i = $i + 2) {
    $pdf->Cell($pw / 4, $h, $sign.$bot_signs[$i], 0);
    $pdf->Cell($pw / 2, $h, '', 0, '');
    if (isset($bot_signs[$i + 1])) {
        $next = $bot_signs[$i + 1];
        $next_sign = $sign;
        $next_date = $date;
    } else {
        $next = '';
        $next_sign = '';
        $next_date = '';
    }
    $pdf->Cell($pw / 4, $h, $next_sign.$next, 0, 1);
    $pdf->Cell($pw / 4, $h, $date, 0);
    $pdf->Cell($pw / 2, $h, '', 0, '');
    $pdf->Cell($pw / 4, $h, $next_date, 0, 1);
    if($i !== count($bot_signs) - 1) {
        $pdf->Cell($pw, $h, '', 0, 1);
    }
}

$pdf->Output($_COOKIE['m_year'].'.pdf', 'I', true);
