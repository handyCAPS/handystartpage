<?php

require_once 'db/connection.php';
require_once 'query.php';

require_once 'class.fileupload.php';

$image = $_FILES['image'];

$img_up = new Image_Upload();

$uploaded = $img_up->upload($image);

if ($uploaded['state']) {
	$img_name = $uploaded['name'];
	$img_mime = $uploaded['mime'];
	$img_loc = addslashes($uploaded['location_rel']);
	$insert = add_to_the_db($db, 'images', 'img_name', 'img_mime', 'img_location',"'$img_name', '$img_mime', '$img_loc'");

	$img_id = $db->insert_id;
} else {
	$error_array = $uploaded['upload_errors'];
	$errors = urlencode($errorarray[0]);
	$len = count($errorarray);
	$i = 1;

	if ($len > $i) {

		for (;$i < $len; $i++) {
			$errors .= '&error' . ( $i + 1 ) . '=' . urlencode($errorarray[$i]);
		}
	}
	$error_query .= '?error=' . $errors;
	header('Location:../index.php' . $error_query);
}

$link = $db->real_escape_string(trim($_POST['link']));
$name = $db->real_escape_string(trim(ucfirst($_POST['name'])));
$cat_id = $db->real_escape_string(trim($_POST['cat_id']));
$link_order = $db->real_escape_string(trim($_POST['link_order']));
$description = $db->real_escape_string(trim($_POST['description']));

$result = add_to_the_db($db, 'links', 'link, name, cat_id, link_order, description, img_id', "'$link', '$name', '$cat_id', '$link_order', '$description', '$img_id'");

$db_error = '';

if(!$result) {
	 $db_error_message = 'Could not insert into the db';
	 $db_error = '?error=' urlencode($db_error_message);
}

header('Location: ../' . $db_error);

