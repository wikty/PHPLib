<?php
session_start();
require_once'../mysite.cfg.php';
$page_title='Home Page';
$stylesheets=array('main.css');
$scripts=array('utility.js');
require_once'inc/header.inc.php';
echo '<h1>Current Open Auctions</h1>
	<p>Auctions are listed from those closing soonest to those closing last. ';
	
if (isset($_SESSION['timezone'])) {
	echo 'All times are reflected using your chosen timezone. ';
	//if you can get user's timezone,follow should be:
	//$tz = "CONVERT_TZ(date_closed, 'UTC', '{$_SESSION['timezone']}')";
	//$tz use to query sql
	//assume +00:00 is utc,+08:00 is user timezone
	$tz = "CONVERT_TZ(date_closed, '+00:00', '{$_SESSION['timezone']}')";
	$currentTime="convert_tz(utc_timestamp(),'+00:00','{$_SESSION['timezone']}')";
	$utcFlag='(Your Time)';
} else {
	echo 'All times are Universal Coordinated Time. Please <a href="login.php">log in</a> to have times shown in your chosen timezone. ';
	$tz='date_closed';
	$currentTime='utc_timestamp()';
	$utcFlag='(UTC Time)';
}

echo '</p><table>
	<caption>Click on an item to view that auction.</caption>
		<thead><tr><th>Item</th><th>Current</th><th>Closes'.$utcFlag.'</th></tr></thead>
		<tbody>
';

require_once(MYSQLI);

$sql = "select items.item_id,item,
			coalesce(max(bid),opening_price) as current_price,
			if(date_closed<date_add(utc_timestamp(),interval 24 hour),
				if(day($currentTime)=day($tz),date_format($tz,'Today %l:%i:%p'),date_format($tz,'Tomorrow %l:%i:%p')),
				date_format($tz,'%M %D @ %l:%i:%p'))
			 as over_time
			from items left join bids using(item_id)
			where date_closed>utc_timestamp()
			group by items.item_id 
			order by date_closed";
$r = $dbc->query($sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . $dbc->error);
while (list($itemId, $item, $price, $dateClosed,$isToady) = $r->fetch_array(MYSQLI_NUM)) {
	echo "<tr><td><a href=\"view.php?itemId=$itemId\">$item</a></td><td>{$cfg_locale_money}{$price}</td><td>$dateClosed</td></tr>\n";
}
echo '</tbody></table>';
$r->free();
$dbc->close();
require_once'inc/footer.inc.php';
?>