<?php

require_once 'db/connection.php';
require_once 'query.php';

foreach ($_POST as $key => $value) {
	${$key} = $value;
}

if (update_the_db($db, 'categories', "cat_name = '$cat_name', cat_order = '$cat_order'", "cat_id = $cat_id")) {
	header('Location:../?update=cats&updated=' . $cat_name);
} else {
	echo "Something went wrong updating the database. '$cat_id', '$cat_order', '$cat_name' <a href='../'>Home</a>";
}