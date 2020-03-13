<?php

// Name: schedule editor
    include_once '../model/properties_class.php';
    include_once '../model/database_class.php';
    $is = new database;
    
    $is_closed = $is->select_cols_where('year_close', ['close'], 'id', '1');
    
    echo $is_closed['close'];