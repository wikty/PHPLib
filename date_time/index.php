<?php
include('config.php');

// create datetime
$now=new DateTime();
$dt201408=new DateTime('08/25/2014');
$dt201407=DateTime::createFromFormat('d/m/Y', '25/08/2014');

// interval add and sub
$dt201407->add(new DateInterval('P12D'));
$dt201407->add(DateInterval::createFromDateString('+12 days'));
$interval=$dt201407->diff($dt201408);
$now->modify('-1 month');

// period
$interval = DateInterval::createFromDateString('second Tuesday of next month');
$period = new DatePeriod($dt201408, $interval, 12, DatePeriod::EXCLUDE_START_DATE);
// foreach ($period as $date) {
// 	echo $date->format('l, F jS, Y') . '<br>';
// }
$period = new DatePeriod('R5/2011-02-05T00:00:00Z/P10D');
// foreach ($period as $date) {
// 	echo $date->format('l, F j, Y') . '<br>';
// }

// timezone
$uk=new DateTimeZone('Europe/London');
$us=new DateTimeZone('America/New_York');
$today=new DateTime('now', $uk);
$today->setTimezon($us);


$mystr=nl2br(join('\n', array(
	'Class: DateTime()',
	$now->format('g.ia'),
	$now->format('l, F jS, Y'),
	$now->format('l'),
	$now->getTimezone()->getName(),
	'Function: date() and strtotime()',
	date('g.ia'),
	date('l, F jS, Y'),
	date('l', strtotime('08/25/2014')),
)));

echo $mystr;