<?php
require_once 'db/connection.php';
require_once 'query.php';
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

/**
 * This script gets ajaxed, so we return some text
 */
if (remove_from_the_db($db, 'links', 'id = ' . $id)) {
	return 'Link successfully deleted !';
} else {
	return 'There was a problem updating the database. <a href="../">Home</a>';
}
