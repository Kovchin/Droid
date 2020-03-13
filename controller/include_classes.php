<?php

//use this file to include all models

$folders_list = scandir('../');
$inc_list = '';
for($i = 2; $i < count($folders_list); $i++) {
	$inc_list .= PATH_SEPARATOR.'../'.$folders_list[$i];
}
set_include_path(get_include_path().$inc_list);
spl_autoload_extensions('_class.php');
spl_autoload_register();