<?php

require_once 'db/connection.php';
require_once 'query.php';

foreach ($_POST as $key => $value) {
	${$key} = $db->real_escape_string($value);
}
// $link = urlencode($link);

if (update_the_db($db, 'links', "name='$name', link='$link', link_order='$link_order', image='$image', cat_id='$cat_id', clicks='$clicks', description='$description'", "id='$id'")) {
	header('Location: ../?update=links&category=' . $cat_id);
} else {
	echo 'There was a problem updating the database. <a href="../">Home</a>';
}

