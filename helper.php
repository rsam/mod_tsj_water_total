<!--
TSJ модуль показаний расхода воды.
Версия mod_tsj_waters_total Февраль 2013
Автор RVP
Copyright (C) 2011 joomla-umnik
Лицензия GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
Официальный сайт http://joomlaforum.ru/
-->
<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

global $n_day;
$n_day = 4; // дата смены отчётного периода

$dir_absolute_path=preg_replace('#[/\\\\]+#', '/', dirname(__FILE__));

class ModTSJwatersTotalHelper {
	public function getdata_water1s($waterTotal) {

	//Подключение к бд joomla
	$db = JFactory::getDBO();
	global $n_day;
	
	//Вывод таблицы расхода воды за предыдущий месяц 
	$query = 'SELECT 
	ac.account_num, 
	wd.date_in, 
	wd.data_hot_c1, 
	wd.data_cold_c1, 
	wd.data_hot_c2, 
	wd.data_cold_c2, 
	wd.data_hot_c3, 
	wd.data_cold_c3 
	FROM #__tsj_account AS ac, 
	#__tsj_water_data AS wd, 
	#__tsj_water_office AS wo 
	WHERE wd.office_counter_id = wo.office_counter_id 
	AND ac.account_id = wo.account_id  
	AND wd.date_in > LAST_DAY( DATE_SUB( CURDATE( ) , INTERVAL 2 MONTH ) ) + INTERVAL '.$n_day.' DAY 
	AND wd.date_in < DATE_ADD( LAST_DAY( CURDATE( ) - INTERVAL 1 MONTH ) , INTERVAL 1 DAY ) + INTERVAL '.$n_day.' DAY 
	ORDER BY ac.account_id';
	$db->setQuery($query);
	$data_water1s = $db->loadObjectlist();
	return $data_water1s;
	} 
	

    public function getdata_water2s($waterTotal) {
	global $n_day;
	//Подключение к бд joomla
	$db = JFactory::getDBO();
	
	//Вывод таблицы расхода воды за текущий месяц
	$query = 'SELECT 
	ac.account_num, 
	wd.date_in, 
	wd.data_hot_c1, 
	wd.data_cold_c1, 
	wd.data_hot_c2, 
	wd.data_cold_c2, 
	wd.data_hot_c3, 
	wd.data_cold_c3 
	FROM #__tsj_account AS ac, 
	#__tsj_water_data AS wd, 
	#__tsj_water_office AS wo 
	WHERE wd.office_counter_id = wo.office_counter_id 
	AND ac.account_id = wo.account_id 
	AND wd.date_in > LAST_DAY(CURDATE()) + INTERVAL '.$n_day.' DAY - INTERVAL 1 MONTH 
	AND wd.date_in < DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY) 
	ORDER BY ac.account_id';
	$db->setQuery($query);
	$data_water2s = $db->loadObjectlist();
	return $data_water2s;
	}
	
	public function getdata_water3s($waterTotal) {

	//Подключение к бд joomla
	$db = JFactory::getDBO();
	
	//Выбираем из какой таблицы будем вытаскивать данные
	$query = 'SELECT '
	.'DISTINCT  *' 
	.'FROM #__tsj_account AS ac' 
//	.'LEFT JOIN #__tsj_water_office AS wo'
//	.'ON ac.account_id = wo.account_id'
	;	
	$db->setQuery($query);
	$data_water3s = $db->loadObjectlist();
	return $data_water3s;
	}
}
