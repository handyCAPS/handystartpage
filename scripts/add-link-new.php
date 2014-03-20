<?php

require_once 'db/connection.php';
require_once 'query.php';

function check_image_is_uploaded($db, $img_id) {

	$result = ask_the_db($db, 'images', '*', 'img_id = $img_id');

	if (is_array($result)) {
		return true;
	}

	if (DEBUG && !is_array($result)) {
		var_dump($result);
		return;
	}

	return false;
}

function add_link_to_the_db($db) {

	$link 			= $db->real_escape_string(trim($_POST['link']));
	$img_id 		= $db->real_escape_string(trim($_POST['img_id']));
	$link_name 	= $db->real_escape_string(trim($_POST['name']));
	$category 	= $db->real_escape_string(trim($_POST['cat_id']));
	$descript		= $db->real_escape_string(trim($_POST['description']));
	$order 			= $db->real_escape_string(trim($_POST['link_order']));


}