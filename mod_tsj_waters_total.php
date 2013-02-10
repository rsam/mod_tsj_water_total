<?php
//no direct access
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
 
// подключаем файл helper.php
require_once(dirname(__FILE__).DS.'helper.php');
 
// берем параметры из файла конфигурации
$waterTotal = $params->get('watertotal');
 
// берем water1s из файла helper
$data_water1s = ModTSJwatersTotalHelper::getdata_water1s($waterTotal);

// берем water2s из файла helper
$data_water2s = ModTSJwatersTotalHelper::getdata_water2s($waterTotal);

// берем water3s из файла helper
$data_water3s = ModTSJwatersTotalHelper::getdata_water3s($waterTotal);
 
// подключаем шаблон для отображения 
require(JModuleHelper::getLayoutPath('mod_tsj_waters_total'));