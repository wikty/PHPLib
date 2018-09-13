<?php
session_start();
require_once'../mysite.cfg.php';
$page_title='Bid';
$stylesheets=array('main.css');
$scripts=array('utility.js');
require_once'inc/header.inc.php';
$itemId=null;
if(isset($_GET[itemId]) && filter_var($_GET[itemId],FILTER_VALIDATE_INT,array('min_range=>1'))){
	$itemId=$_GET[itemId];
}
elseif(isset($_POST[itemId]) && filter_var($_POST[itemId],FILTER_VALIDATE_INT,array('min_range=>1'))){
	$itemId=$_POST[itemId];
}

if(!$itemId){
	echo '<h2>Error! </h2><p class="error">This page has been accessed error!</p>';
	include'inc/footer.inc.php';
	exit;
}

if(isset($_SESSION[timezone])){
	$submitTime='convert_tz(date_submitted,"+00:00","'.$_SESSION[timezone].'")';
	$currentTime='convert_tz(utc_timestamp(),"+00:00","'.$_SESSION[timezone].'")';
	$startTime='convert_tz(date_opened,"+00:00","'.$_SESSION[timezone].'")';
	$endTime='convert_tz(date_closed,"+00:00","'.$_SESSION[timezone].'")';
}
else{
	$submitTime='date_submitted';
	$currentTime='utc_timestamp()';
	$startTime='date_opened';
	$endTime='date_closed';
}
require_once(MYSQLI);

if($_SERVER[REQUEST_METHOD]=='POST'){
	if(isset($_SESSION[userId]) && filter_var($_SESSION[userId],FILTER_VALIDATE_INT,array('min_range=>1'))){
		$userId=$_SESSION[userId];
	}
	if(isset($_POST[bid]) && filter_var($_POST[bid],FILTER_VALIDATE_FLOAT) && $_POST[bid]>$_POST[currentHidden]){
		$bid=$_POST[bid];
	}
	if(isset($userId,$bid)){
		$sql='select item from items where item_id='.$itemId.' and user_id='.$userId;
		$r=$dbc->query($sql);
		if($r->num_rows)
		{
			echo '<h2>Warging!</h2><p class="error">Hai! man you can bid for yourself!</p>';
		}
		else{
			$sql='insert into bids
					(user_id,item_id,date_submitted,bid)
					values
					('.$userId.','.$itemId.',utc_timestamp(),'.$bid.')';
			$dbc->query($sql);
			if($dbc->affected_rows==1){
				echo '<h2>Bid Accepted!</h2><p class="good">Your bid of $' . $bid . ' has been accepted.</p>';
			}
			else{
				echo '<h2>Error!</h2><p class="error">Your bid could not be accepted due to a system error. We apologize for the convenience.</p>';
			}
		}
	}
	else{
		echo '<h2>Error!</h2><p class="error">Your bid could not be accepted. Make sure it is greater than the current high price!</p>';
	}
}

$sql="select item,description,opening_price,coalesce(max(bid),opening_price),$startTime,if(day($endTime)=day($currentTime),DATE_FORMAT($endTime,'Today %l:%i %p'),DATE_FORMAT($endTime,'%M %D @ %l:%i %p')) as endTime
			,if(date_closed>utc_timestamp(),CEILING((UNIX_TIMESTAMP(date_closed)-UNIX_TIMESTAMP(utc_timestamp()))/60),'Closed')
			from items left join bids using(item_id)
			where items.item_id=$itemId
			group by bids.item_id";
$r=$dbc->query($sql);

list($item,$description,$oPrice,$cPrice,$sTime,$eTime,$status)=$r->fetch_array(MYSQLI_NUM);
echo "<h1 id=\"itemHeading\">$item</h1>
<p>$description</p>
<h2>Opening Price: {$cfg_locale_money}{$oPrice}</h2>
<h2>Current Price: {$cfg_locale_money}{$cPrice}</h2>
<h2>Start Time: {$sTime}</h2>
<h2 id=\"closingH2\">Closes</em>: $eTime";
if (($status != 'Closed') && $status<60) {
	echo ' <span id="minutesRemainingSpan" class="caution">' . $status . ' minute(s) left</span>';
}

if ($status != 'Closed') {

	echo '<h3>Bid On This Item</h3>
	<p>Enter a price above '.$cfg_local_money.'<span id="currentSpan">' .  $cPrice . '</span> to bid on this item.</p>';

	if (isset($_SESSION['userId'])) {
		echo '<form action="view.php" method="post" id="bidForm">
		<label>Bid</label>
		<input name="bid" id="bid" type="text">
		<br>
		<input class="button" type="submit" value="Bid">
		<input type="hidden" name="itemId" id="itemId" value="' . $itemId . '">
		<input type="hidden" name="currentHidden" id="currentHidden" value="' . $cPrice . '">
	</form>';
	} else { // Not logged in.
		echo '<p class="caution">You must <a href="login.php?frompage=view.php">log in</a> to place bids.</p>';
	}
	
	// Create the JavaScript:
	echo '<script>
		var itemId = ' . $itemId . ';
		var currentPrice = ' . $cPrice . ';
		var minutesRemaining  = ' . $status . ';
	</script>
	<script src="js/view.js"></script>';

} else { // Closed!
	echo '<p class="caution">This auction is now closed.</p>
	<h2>Final Price: $' . $cPrice .'</h2>';
}
// Complete the details:
echo '</h2>';
$sql="select bid,if(date_submitted>date_sub($currentTime,interval 24 hour),if(day($currentTime)=day(date_submitted),DATE_FORMAT($submitTime,'Today %l:%i %p'),DATE_FORMAT($submitTime,'Yesterday  %l:%i %p')),DATE_FORMAT($submitTime,'%M %D @ %l:%i %p')) as subTime
			from bids
			where item_id=$itemId
			order by bid desc";
$r=$dbc->query($sql);
echo "<h3>Current Bids</h3>
<p id=\"refreshMessage\"><a href=\"view.php?itemId=" . $itemId . "\">Refresh the page to update.</a></p>
<table>
	<caption>All bids for this item, in descending order.</caption>
	<thead><tr><th>Bid</th><th>Date</th></tr></thead>
	<tbody id=\"tableBody\">
";
while(list($bid,$subTime)=$r->fetch_array(MYSQLI_NUM)){
echo '<tr><td>'.$cfg_locale_money.$bid.'</td><td>'.$subTime.'</td></tr>';
}
echo '</tbody></table>';

if (isset($_SESSION['timezone'])) {
	echo '<p>All times are reflected using your chosen timezone.</p>';
} else {
	echo '<p>All times are Universal Coordinated Time. Please <a href="login.php">log in</a> to have times shown in your chosen timezone.</p>';
}
require_once'inc/footer.inc.php';
?>