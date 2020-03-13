<?php

class reports 
{
    private $db;
    public $reports_list;
    
    const READY = '<span class="ready">Готово</span>';
    const NOT_READY = '<span class="unready">Не готово</span>';
    
    public function __construct()
    {
        $this->db = new database();
    }
    
    private function get_folder($path)
    {
        $res = [];
        exec("dir $path /b", $res);
        $res = array_map( function ($val) {
                return iconv('CP866', 'UTF-8', trim($val));          
            }, $res);
        return $res;
    }
      
    public function experts()
    {
        $res = $this->get_folder("\\\\root-fs-01.sibmes.fsk\\МУСЭ\\Отчеты\\409");
        
        $weekday = date('w', time());
        if ($weekday == 1) $day_dif = -259200;
        elseif ($weekday == 2) $day_dif = -345600;
        elseif ($weekday == 3) $day_dif = -432000;
        elseif ($weekday == 4) $day_dif = -518400;
        elseif ($weekday == 5) $day_dif = 0;
        elseif ($weekday == 6) $day_dif = -886400;
        elseif ($weekday == 7) $day_dif = -172800;
        
        $control_date = time() + $day_dif;
        $this->db->update('reports', 'control_date', $control_date, 'id', '3');
        $date = date('y-m-d', $control_date);

        foreach ($res as $r) {
            if (stristr($r, $date.' Отчет о проделанной работе')) {
                $this->db->update('reports', 'severob', $this::READY, 'id', '3');
                return true;
            }
        }
        
        $this->db->update('reports', 'severob', $this::NOT_READY, 'id', '3');
        return false;
    }
    
    public function vocation_erg()
    {
        
        $year = date('Y', time()) + 1;
        $res = $this->get_folder("\\\\root-fs-01.sibmes.fsk\\МУСЭ\\Графики\\Отпусков\\"
                .$year."\\ЭРГ");
        
        $this->db->update('reports', 'control_date', strtotime('31-12-'.($year - 1)), 'id', '4');
        
        $s = $this::NOT_READY;
        $k = $this::NOT_READY;
        $h = $this::NOT_READY;
        $kem = $this::NOT_READY;
        $t = $this::NOT_READY;
        $n = $this::NOT_READY;
        $o = $this::NOT_READY;
        
        foreach ($res as $r) {
            if (mb_stristr($r, 'северобайкальск')) $s = $this::READY;
            if (mb_stristr($r, 'красноярск')) $k = $this::READY;
            if (mb_stristr($r, 'хакасс')) $h = $this::READY;
            if (mb_stristr($r, 'кемеров')) $kem = $this::READY;
            if (mb_stristr($r, 'томск')) $t = $this::READY;
            if (mb_stristr($r, 'новосибирск')) $n = $this::READY;
            if (mb_stristr($r, 'омск') && !stristr($r, 'томск')) $o = $this::READY;
        }
        
        $column_arr = ['severob', 'kras', 'hakas', 'kemerovo', 'tomsk', 'novosib', 'omsk'];
        $data_arr = [$s, $k, $h, $kem, $t, $n, $o];
        $this->db->multi_update('reports', $column_arr, $data_arr, 'id', '4');
        
    }
    
    public function vocation()
    {
        
        $year = date('Y', time()) + 1;
        $res = $this->get_folder("\\\\root-fs-01.sibmes.fsk\\МУСЭ\\Графики\\Отпусков\\"
                .$year);
        
        $this->db->update('reports', 'control_date', strtotime('31-12-'.($year - 1)), 'id', '5');
        
        $s = $this::NOT_READY;
        
        foreach ($res as $r) {
            if (mb_stristr($r, 'График отпусков ' . $year)) $s = $this::READY;
        }
        
        $this->db->update('reports', 'severob', $s, 'id', '5');
        
    }
    
}