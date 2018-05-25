<?php if( ! defined('BASEPATH')) exit('No direct script access allowed.');
/**
 * Date Time Helper
 *
 * @author 					Joss Arciga
 * @copyright 				Copyright (c) 2015. Inttechs, Internet Technologies.
 * @creation date 			July 30, 2015
*/
function get_timestamp()
{
	$date = new DateTime();
	return $date->getTimestamp();
}

function convert_time_to_24_format($time = '9:40:47 PM')
{
	$arr = explode(' ', $time);

	$time = explode(':', $arr[0]);
	$hours = $time[0];
	$minutes = $time[1];
	$seconds = $time[2];

	if($arr[1] == 'AM')
	{
		if($hours < 10)
			$hours = '0'.$hours;

		if($minutes < 10)
			$minutes = '0'.$minutes;

		if($seconds < 10)
			$seconds = '0'.$seconds;
	}
	else
	{
		$hours = $hours + 12;
	}

	return $hours.':'.$minutes.':'.$seconds;
}

function get_month_number($month_name = 'Jan')
{
	$month_number = '01';

	switch($month_name)
	{
		case 'Jan':
			$month_number = '01';
			break;

		case 'Feb':
			$month_number = '02';
			break;

		case 'Mar':
			$month_number = '03';
			break;

		case 'Apr':
			$month_number = '04';
			break;

		case 'May':
			$month_number = '05';
			break;

		case 'Jun':
			$month_number = '06';
			break;

		case 'Jul':
			$month_number = '07';
			break;

		case 'Aug':
			$month_number = '08';
			break;

		case 'Sep':
			$month_number = '09';
			break;

		case 'Oct':
			$month_number = '10';
			break;

		case 'Nov':
			$month_number = '11';
			break;

		case 'Dec':
			$month_number = '12';
			break;
	}

	return $month_number;
}

function convert_date($date_time_str = 'Dec 9, 2016 9:40:47 PM')
{
	$p0 = explode(',', $date_time_str);
	$p1 = explode(' ', $p0[0]);

	$month = $p1[0];
	$day = $p1[1];

	$p2 = explode(' ', $p0[1]);
	$year = $p2[1];
	$time = $p2[2];
	$ampm = $p2[3];

	$month = get_month_number($month);

	if($day < 10)
		$day = '0'.$day;

	$time = convert_time_to_24_format($time.' '.$ampm);

	return array($year.'-'.$month.'-'.$day, $time);
}

function get_date_string($date = '0000-00-00')
{
	$date_array = explode('-', $date);
	$day = intval($date_array[2]);
	$month = get_month_name($date_array[1]);
	$year = $date_array[0];

	return $day.' de '.$month.' de '.$year;
}

function get_date()
{
	return date('Y').'-'.date('m').'-'.date('d');
}

function get_time()
{
	return date('H').':'.date('i').':'.date('s');
}

function get_date_time()
{
	return get_date().' '.get_time();
}

function get_current_month()
{
	return date('m');
}

function get_current_day()
{
	return date('d');
}

function get_current_year()
{
	return date('Y');
}

function get_current_hour()
{
	return date('H');
}

function get_current_minute()
{
	return date('i');
}

function get_current_second()
{
	return date('s');
}

function get_month_name($month_number = '01')
{
	$month = intval($month_number);

	switch($month)
	{
		case 1:
			$month = 'Enero';
			break;
		case 2:
			$month = 'Febrero';
			break;
		case 3: 
			$month = 'Marzo';
			break;
		case 4:
			$month = 'Abril';
			break;
		case 5:
			$month = 'Mayo';
			break;
		case 6:
			$month = 'Junio';
			break;
		case 7:
			$month = 'Julio';
			break;
		case 8:
			$month = 'Agosto';
			break;
		case 9: 
			$month = 'Septiembre';
			break;
		case 10: 
			$month = 'Octubre';
			break;
		case 11:
			$month = 'Noviembre';
			break;
		case 12:
			$month = 'Diciembre';
			break;
	}

	return $month;
}
?>