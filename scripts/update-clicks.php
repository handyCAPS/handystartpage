<?php

require_once 'db/connection.php';

function get_the_clicks($db, $id) {
	$sql = "SELECT clicks FROM links WHERE id='$id'";
	$results = $db->query($sql);
	$row = $results->fetch_assoc();
	return $row['clicks'];
}

function update_the_clicks($db, $id) {
	$old_clicks = (int) get_the_clicks($db,$id);
	$new_clicks = $old_clicks + 1;
	$sql = "UPDATE links SET clicks='$new_clicks' WHERE id='$id'";

	$db->query($sql);
}

$id = $_REQUEST['id'];
update_the_clicks($db,$id);
