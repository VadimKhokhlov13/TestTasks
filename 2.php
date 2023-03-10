<?php

/**
 * @charset UTF-8
 *
 * Задание 2. Работа с массивами и строками.
 *
 * Есть список временных интервалов (интервалы записаны в формате чч:мм-чч:мм).
 *
 * Необходимо написать две функции:
 *
 *
 * Первая функция должна проверять временной интервал на валидность
 * 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм)
 * 	возвращать boolean
 *
 *
 * Вторая функция должна проверять "наложение интервалов" при попытке добавить новый интервал в список существующих
 * 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм)
 *  возвращать boolean
 *
 *  "наложение интервалов" - это когда в промежутке между началом и окончанием одного интервала,
 *   встречается начало, окончание или то и другое одновременно, другого интервала
 *
 *  пример:
 *
 *  есть интервалы
 *  	"10:00-14:00"
 *  	"16:00-20:00"
 *
 *  пытаемся добавить еще один интервал
 *  	"09:00-11:00" => произошло наложение
 *  	"11:00-13:00" => произошло наложение
 *  	"14:00-16:00" => наложения нет
 *  	"14:00-17:00" => произошло наложение
 */

# Можно использовать список:

$list = array (
	'09:00-11:00',
	'11:00-13:00',
	'15:00-16:00',
	'17:00-20:00',
	'20:30-21:30',
	'21:30-22:30',
);

function isValidInterval($interval) {
	$patternTime = '/^([0-1][0-9]|2[0-3]):[0-5][0-9]-([0-1][0-9]|2[0-3]):[0-5][0-9]$/';
	return preg_match($patternTime, $interval);
}

function checkIntersect($interval) {
	global $list;
    $countOfMinutes = 1440;
	$t1 = explode("-", $interval);
    $offset = getMinutes($t1[0]);
    $finish = (getMinutes($t1[1]) + $countOfMinutes - $offset) % $countOfMinutes;
    foreach ($list as $item) {
    	$t2 = explode("-", $item);
    	$startInterval = (getMinutes($t2[0]) + $countOfMinutes - $offset) % $countOfMinutes;
        $finishInterval = (getMinutes($t2[1]) + $countOfMinutes - $offset - 1) % $countOfMinutes;
        if ($startInterval > $finishInterval || $startInterval < $finish) {
        	return "есть наложение";
        }
    }
    return "наложения нет";
}

function getMinutes($time) {
	[$h, $m] = explode(":", $time);
	return 60 * $h + $m;
}

?>
