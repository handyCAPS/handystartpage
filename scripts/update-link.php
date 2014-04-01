<?php

require_once 'db/connection.php';
require_once 'query.php';
require_once 'class.fileupload.php';

// foreach ($_POST as $key => $value) {
// 	${$key} = $db->real_escape_string($value);
// }
// $link = urlencode($link);

$name 				= $_POST['name'];
$link 				= $_POST['link'];
$link_order 	= $_POST['link_order'];
$cat_id 			= $_POST['cat_id'];
$clicks 			= $_POST['clicks'];
$description 	= $_POST['description'];
$id 					= $_POST['id'];

if (isset($_FILES['image'])) {
	$image = isset($_FILES['image']);

	$img_upload = new ImageUpload();

	$result = $img_upload->upload($image);
}

if (update_the_db($db, 'links', "name='$name', link='$link', link_order='$link_order', cat_id='$cat_id', clicks='$clicks', description='$description'", "id='$id'")) {
	header('Location: ../?update=links&category=' . $cat_id);
} else {
	echo 'There was a problem updating the database. <a href="../">Home</a>';
}

