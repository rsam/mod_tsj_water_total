﻿<!--
TSJ модуль показаний расхода воды.
Версия mod_tsj_waters_total Февраль 2013
Автор RVP
Copyright (C) 2011 joomla-umnik
Лицензия GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
Официальный сайт http://joomlaforum.ru/
-->
<?php defined('_JEXEC') or die('Restricted access'); // запрет к прямому обращению
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'../helper.php');
?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="/media/com_tsj/js/datepicker.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="/media/com_tsj/js/datepicker.css" />

<link
	rel="stylesheet" type="text/css"
	href="modules/mod_tsj_waters_total/tsj_waters_total.css">
<div id="linked-active">

<?php 
//echo "<h2>Дата смены отчётного периода - $comparams['water_stopDay']</h2>";

//-- определяем массив для месяцев --
$q[]="";
$q[]="января";
$q[]="февраля";
$q[]="марта";
$q[]="апреля";
$q[]="мая";
$q[]="июня";
$q[]="июля";
$q[]="августа";
$q[]="сентября";
$q[]="октября";
$q[]="ноября";
$q[]="декабря";

//-- определяем массив для дней недели --
$e[0]="воскресенье";
$e[1]="понедельник";
$e[2]="вторник";
$e[3]="среда";
$e[4]="четверг";
$e[5]="пятница";
$e[6]="суббота";

// ---- считываем месяц
$m=date('m');
if ($m=="01") $m=1;
if ($m=="02") $m=2;
if ($m=="03") $m=3;
if ($m=="04") $m=4;
if ($m=="05") $m=5;
if ($m=="06") $m=6;
if ($m=="07") $m=7;
if ($m=="08") $m=8;
if ($m=="09") $m=9;

// ---- считываем день недели
$we=date('w');

// ---- считываем число
$chislo=date('d');

// - извлекаем из день недели
$den_nedeli = $e[$we];

// - извлекаем значениечение месяца
$mesyac_prev = ($q[$m-1]);
$mesyac_car = ($q[$m]);
if ($m==1) $mesyac_prev = ($q[12]);
// - конец вывода даты


$styletype=$params->get('styletype','');

if ($styletype==1) {
	echo "<h2>Показания счётчиков за период с ".$comparams['water_stopDay']." ".$mesyac_prev." по ".$comparams['water_stopDay']." ".$mesyac_car." ".date('Y')." г</h2>";
	echo '<br />';

	//	echo 'первый вариант модуля<br />';
	echo "Таблица показаний предыдущий месяц<br />";
	echo '<a href="/modules/mod_tsj_waters_total/logs/'.date("Y-m").'-previous_month.csv" target="_blank">Скачать файл за предыдущий месяц<br /></a>';
	$f = fopen("$dir_absolute_path/logs/".date("Y-m")."-previous_month.csv", "w") or die ();
	fputs ($f, "\"№\";\"account_num\";\"date\";\"гвс1\";\"хвс1\";\"гвс2\";\"хвс2\";\"гвс3\";\"хвс3\" \r\n");
	echo '<br />';
	echo '<table width="100%" cellpadding="2" cellspacing="2">';
	echo '<tr>
		<th align="center" rowspan="2">№</th>
		<th align="center" rowspan="2">Лицевой счет</th>
		<th align="center" rowspan="2">Дата</th>
		<th align="center" colspan="2">Место установки 1</th>
		<th align="center" colspan="2">Место установки 2</th>
		<th align="center" colspan="2">Место установки 3</th>
		</tr>
		<tr>
		<th align="center">ГВС</th>
		<th align="center">ХВС</th>
		<th align="center">ГВС</th>
		<th align="center">ХВС</th>
		<th align="center">ГВС</th>
		<th align="center">ХВС</th>
		</tr>';
	foreach ($data_water1s as $key=>$data_water1 ) {
		echo '<tr>';
		echo '<td align="center">'.($key+1).'</td>
			<td align="center">'.$data_water1->account_num.'</td>
			<td align="center">'.$data_water1->date_in.'</td>
			<td align="center">'.$data_water1->data_hot_c1.'</td>
			<td align="center">'.$data_water1->data_cold_c1.'</td>
			<td align="center">'.$data_water1->data_hot_c2.'</td>
			<td align="center">'.$data_water1->data_cold_c2.'</td>
			<td align="center">'.$data_water1->data_hot_c3.'</td>
			<td align="center">'.$data_water1->data_cold_c3.'</td>';
		echo '</tr>';
		$namer_string=$key+1;
		fputs ($f, "\"$namer_string\";\"$data_water1->account_num\";\"$data_water1->date_in\";\"$data_water1->data_hot_c1\";\"$data_water1->data_cold_c1\";\"$data_water1->data_hot_c2\";\"$data_water1->data_cold_c2\";\"$data_water1->data_hot_c3\";\"$data_water1->data_cold_c3\" \r\n");
	}
	fclose($f);
	echo '</table>';
	echo "<br /><br />";


	echo "Таблица показаний текущий месяц<br />";
	echo '<a href="/modules/mod_tsj_waters_total/logs/'.date("Y-m").'-current_month.csv" target="_blank">Скачать файл за текущий месяц</a><br />';
	$f = fopen("$dir_absolute_path/logs/".date("Y-m")."-current_month.csv", "w") or die ();
	fputs ($f, "\"№\";\"account_num\";\"date\";\"гвс1\";\"хвс1\";\"гвс2\";\"хвс2\";\"гвс3\";\"хвс3\" \r\n");
	echo '<br />';
	echo '<table width="100%" cellpadding="2" cellspacing="2">';
	echo '<tr>
		<th align="center" rowspan="2">№</th>
		<th align="center" rowspan="2">Лицевой счет</th>
		<th align="center" rowspan="2">Дата</th>
		<th align="center" colspan="2">Место установки 1</th>
		<th align="center" colspan="2">Место установки 2</th>
		<th align="center" colspan="2">Место установки 3</th>
		</tr>
		<tr>
		<th align="center">ГВС</th>
		<th align="center">ХВС</th>
		<th align="center">ГВС</th>
		<th align="center">ХВС</th>
		<th align="center">ГВС</th>
		<th align="center">ХВС</th>
		</tr>';
	foreach ($data_water2s as $key=>$data_water2 ) {
		echo '<tr>';
		echo '<td align="center">'.($key+1).'</td>
			<td align="center">'.$data_water2->account_num.'</td>
			<td align="center">'.$data_water2->date_in.'</td>
			<td align="center">'.$data_water2->data_hot_c1.'</td>
			<td align="center">'.$data_water2->data_cold_c1.'</td>
			<td align="center">'.$data_water2->data_hot_c2.'</td>
			<td align="center">'.$data_water2->data_cold_c2.'</td>
			<td align="center">'.$data_water2->data_hot_c3.'</td>
			<td align="center">'.$data_water2->data_cold_c3.'</td>';
		echo '</tr>';
		$namer_string=$key+1;
		fputs ($f, "\"$namer_string\";\"$data_water2->account_num\";\"$data_water2->date_in\";\"$data_water2->data_hot_c1\";\"$data_water2->data_cold_c1\";\"$data_water2->data_hot_c2\";\"$data_water2->data_cold_c2\";\"$data_water2->data_hot_c3\";\"$data_water2->data_cold_c3\" \r\n");
	}
	fclose($f);
	echo '</table>';
} else if ($styletype==2) {
	echo "<h2>Показания счётчиков за период с ".$comparams['water_stopDay']." ".$mesyac_prev." по ".$comparams['water_stopDay']." ".$mesyac_car." ".date('Y')." г</h2>";
	echo '<br />';

	//	echo "Таблица жильцов<br />";

	//Подключение к бд joomla
	$db = JFactory::getDBO();

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
	AND wd.date_in > LAST_DAY( DATE_SUB( CURDATE( ) , INTERVAL 2 MONTH ) ) + INTERVAL '.$comparams['water_stopDay'].' DAY 
	AND wd.date_in < DATE_ADD( LAST_DAY( CURDATE( ) - INTERVAL 1 MONTH ) , INTERVAL 1 DAY ) + INTERVAL '.$comparams['water_stopDay'].' DAY  
	ORDER BY date_in desc';
	$db->setQuery($query);
	$data_waters = $db->loadObjectlist();

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
	AND wd.date_in > LAST_DAY( DATE_SUB( CURDATE( ) , INTERVAL 5 MONTH ) ) + INTERVAL '.$comparams['water_stopDay'].' DAY 
	AND wd.date_in < DATE_ADD( LAST_DAY( CURDATE( ) - INTERVAL 2 MONTH ) , INTERVAL 1 DAY ) + INTERVAL '.$comparams['water_stopDay'].' DAY  
	ORDER BY date_in desc';
	$db->setQuery($query);
	$data_waters_olds = $db->loadObjectlist();

	//echo '<pre>';
	//print_r ($data_waters_olds);
	//echo '</pre>';

	echo '<br />';
	echo '<table width="100%" cellpadding="2" cellspacing="2">';
	echo '<tr>
		<th align="center" rowspan="2">№</th>
		<th align="center" rowspan="2">Номер<br />квартиры</th>
		<th align="center" rowspan="2">Дата<br />снятия<br />показаний</th>
		<th align="center" colspan="2">Место установки 1</th>
		<th align="center" colspan="2">Место установки 2</th>
		<th align="center" colspan="2">Расход</th>
		</tr>
		<tr>
		
		<th align="center">ХВС</th>
		<th align="center">ГВС</th>
		<th align="center">ХВС</th>
		<th align="center">ГВС</th>
		<th align="center">ХВС</th>
		<th align="center">ГВС</th>
		</tr>';

	foreach ($data_water3s as $key=>$data_water3 ) {
		$data_w='';
		$data_hot_c1='';
		$data_cold_c1='';
		$data_hot_c2='';
		$data_cold_c2='';
		$data_hot_c3='';
		$data_cold_c3='';
		$data_w_old='';
		$data_hot_c1_old='';
		$data_cold_c1_old='';
		$data_hot_c2_old='';
		$data_cold_c2_old='';
		$data_hot_c3_old='';
		$data_cold_c3_old='';

		foreach ($data_waters as $data_water ) {
			if (($data_water3->account_num)==($data_water->account_num)){
				$data_w = $data_water->date_in;
				$data_hot_c1 = $data_water->data_hot_c1;
				$data_cold_c1 = $data_water->data_cold_c1;
				$data_hot_c2 = $data_water->data_hot_c2;
				$data_cold_c2 = $data_water->data_cold_c2;
				$data_hot_c3 = $data_water->data_hot_c3;
				$data_cold_c3 = $data_water->data_cold_c3;
				break;
			}
		}
		foreach ($data_waters_olds as $data_waters_old ) {
			if (($data_water3->account_num)==($data_waters_old->account_num)){
				$data_w_old = $data_waters_old->date_in;
				$data_hot_c1_old = $data_waters_old->data_hot_c1;
				$data_cold_c1_old = $data_waters_old->data_cold_c1;
				$data_hot_c2_old = $data_waters_old->data_hot_c2;
				$data_cold_c2_old = $data_waters_old->data_cold_c2;
				$data_hot_c3_old = $data_waters_old->data_hot_c3;
				$data_cold_c3_old = $data_waters_old->data_cold_c3;
				break;
			}
		}
		echo '<tr>';
		echo '
		<td align="center">'.($key+1).'</td>
		<td align="center">'.$data_water3->account_num.'</td>
		<td align="center">'.$data_w.'</td>
		<td align="center">'.$data_cold_c1.'</td>
		<td align="center">'.$data_hot_c1.'</td>
		<td align="center">'.$data_cold_c2.'</td>
		<td align="center">'.$data_hot_c2.'</td>
		<td align="center">';
		echo ($data_cold_c1!='') ? (($data_cold_c1-$data_cold_c1_old)+($data_cold_c2-$data_cold_c2_old)) : '';
		echo '</td>
		<td align="center">';
		echo ($data_hot_c1!='') ? (($data_hot_c1-$data_hot_c1_old)+($data_hot_c2-$data_hot_c2_old)) : '';
		echo '</td>';
		echo '</tr>';
	}
	echo '</table>';
	echo "<br /><br />";
}
else if ($styletype==3) {
	?>
	<form class="form-validate" name="datewaters" id="datewaters"
		action="<?php echo JRoute::_('index.php'); ?>" method="post">
		<fieldset>
		<?php

		$value_start = date('d.m.Y');
		$value_stop = date('d.m.Y');
		
		$f = 2;
		ModTSJwatersTotalHelper::setFirst($f);
		$f = ModTSJwatersTotalHelper::getFirst();
		echo $f;
		
		//echo JHTML::_('behavior.calendar');
		//echo JHTML::_('calendar', $value, 'startdate', 'startdate', '%d-%m-%Y');
		//echo JHTML::_('calendar', $value, 'stopdate', 'stopdate', '%d-%m-%Y');
		?>
		<input name="startdate" id="startdate" value="<?php echo($value_start); ?>" class='datepicker'>
		<input name="stopdate" id="stopdate" value="<?php echo($value_stop); ?>" class="datepicker">

			<input id="submit" name="submit" type="submit"
				value="Сформировать отчет" />
				<?php echo JHtml::_('form.token'); ?>
		</fieldset>

		<div class="clr"></div>
	</form>
	<?php
	// если нажали на кнопку
	if( isset($_POST['submit']))
	{
		$startdate = $_POST['startdate'];
		$stopdate = $_POST['stopdate'];
		$value_start = $startdate;
		$value_stop = $stopdate;

		$data_water4s = ModTSJwatersTotalHelper::getdata_water4s($waterTotal, $startdate, $stopdate);
		echo "<h2>Показания счётчиков за период с ".$startdate." по ".$stopdate."г.</h2>";
		echo '<br />';

		echo '<a href="/modules/mod_tsj_waters_total/logs/'.date("Y-m").'-current_month.csv" target="_blank">Скачать файл за отчетный период</a><br />';
		$f = fopen("$dir_absolute_path/logs/".date("Y-m")."-current_month.csv", "w") or die ();
		fputs ($f, "\"№\";\"account_num\";\"date\";\"гвс1\";\"хвс1\";\"гвс2\";\"хвс2\";\"гвс3\";\"хвс3\" \r\n");
		echo '<br />';
		echo '<table width="100%" cellpadding="2" cellspacing="2">';
		echo '<tr>
		<th align="center" rowspan="2">№</th>
		<th align="center" rowspan="2">Лицевой счет</th>
		<th align="center" rowspan="2">Дата</th>
		<th align="center" colspan="2">Место установки 1</th>
		<th align="center" colspan="2">Место установки 2</th>
		<th align="center" colspan="2">Место установки 3</th>
		</tr>
		<tr>
		<th align="center">ГВС</th>
		<th align="center">ХВС</th>
		<th align="center">ГВС</th>
		<th align="center">ХВС</th>
		<th align="center">ГВС</th>
		<th align="center">ХВС</th>
		</tr>';
		foreach ($data_water4s as $key=>$data_water4 ) {
			echo '<tr>';
			echo '<td align="center">'.($key+1).'</td>
			<td align="center">'.$data_water4->account_num.'</td>
			<td align="center">'.$data_water4->date_in.'</td>
			<td align="center">'.$data_water4->data_hot_c1.'</td>
			<td align="center">'.$data_water4->data_cold_c1.'</td>
			<td align="center">'.$data_water4->data_hot_c2.'</td>
			<td align="center">'.$data_water4->data_cold_c2.'</td>
			<td align="center">'.$data_water4->data_hot_c3.'</td>
			<td align="center">'.$data_water4->data_cold_c3.'</td>';
			echo '</tr>';
			$namer_string=$key+1;
			fputs ($f, "\"$namer_string\";\"$data_water4->account_num\";\"$data_water4->date_in\";\"$data_water4->data_hot_c1\";\"$data_water4->data_cold_c1\";\"$data_water4->data_hot_c2\";\"$data_water4->data_cold_c2\";\"$data_water4->data_hot_c3\";\"$data_water4->data_cold_c3\" \r\n");
		}
		fclose($f);
		echo '</table>';

	}
}

?>
</div>
