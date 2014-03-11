<?php

require_once 'db/connection.php';
require_once 'query.php';
require_once 'class.fileupload.php';

$image = $_FILES['image'];

echo "<h3>Root Folder</h3>";

$root = File_Upload::get_root_path();
$upload_folder = File_Upload::UPLOADS;
var_dump($root);
var_dump($upload_folder);

$imgupload = new Image_Upload();

// $imgupload->max_file_size(800);

$resultupload =$imgupload->upload($image);

echo "<h3>Upload result</h3>";

$errorarray = $resultupload['upload_errors'];

if ($resultupload['state']) {

	var_dump($resultupload);

}

if($filelocation = $imgupload->get_location()) {
	echo "<h3>File Location</h3>";

	var_dump($filelocation);
}

$error_query = '';

if (!empty($errorarray)) {
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

echo "<h3>Saved to db ?</h3>";

function save_img_data($db, $img_array) {
	$img_name = $img_array['name'];
	$img_mime = preg_replace('/image\//','' , $img_array['mime']);
	$img_loc = addslashes($img_array['location_rel']);

	return add_to_the_db($db,'images', 'img_name, img_mime, img_location', "'$img_name', '$img_mime', '$img_loc'");
}

$savetodb = save_img_data($db, $resultupload);
$imgid = $db->insert_id;
var_dump($savetodb);

var_dump($imgid);
