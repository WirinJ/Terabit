<?php

include "../db.inc.php";

if (isset($_GET['user'])) {

	$db = new Dbh();
	$db = $db->connect();

	$user = $_GET['user'];
	//$SELECT `username` FROM `gebruikers` WHERE `username` = 'Andre'

	$likes = $db->query("
	select sum(likes) total
		from
		(
		    select likes
		    from projecten
		    where User = '" . $user . "'
		    union all
		    select likes
		    from comments
		    where uid = '" . $user . "'
		) t")->fetch()[0];

	print_r($likes);
}

?>