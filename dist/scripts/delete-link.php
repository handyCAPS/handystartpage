<?php
require_once 'db/connection.php';
require_once 'query.php';
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

/**
 * This script gets ajaxed, so we echo some text
 */
if (remove_from_the_db($db, 'links', 'id = ' . $id)) {
	echo 'Link successfully deleted !';
} else {
	echo 'There was a problem updating the database. <a href="../">Home</a>';
}
