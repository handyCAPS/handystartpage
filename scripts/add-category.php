<?php
require_once 'db/connection.php';
require_once 'query.php';

$cat_name = $db->real_escape_string($_POST['cat_name']);
$cat_order = $db->real_escape_string($_POST['cat_order']);

if (add_to_the_db($db, 'categories', 'cat_name, cat_order', "'" . $cat_name . "', '" . $cat_order . "'")) {
	header('Location: ../');
} else {
	echo 'There was a problem inserting into the database';
}