<?php

require_once 'db/connection.php';
require_once 'query.php';

$cat_id = $db->real_escape_string($_REQUEST['category']);

function clear_the_clicks($db, $cat) {
	return $result = update_the_db($db, 'links', 'clicks = 0', 'cat_id = ' . $cat);
}

if (clear_the_clicks($db, $cat_id)) {
	header('Location: ../index.php?update=links&category=' . $cat_id);
} else {
	echo "Something went wrong updating the database. <a href='index.php'>Home</a>";
}