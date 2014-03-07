<?php

require_once 'db/connection.php';

function get_upload_dir($root_map, $map_name) {
	$uploaddir = FALSE;
	$limiter = 0;
	if(!is_dir($uploaddir = $root_map . "/$map_name/") && $limiter < 5){
		$limiter++;
		chdir($root_map);
		mkdir($map_name);
		get_upload_dir($root_map, $map_name);
	}
	if ($limiter >= 5) {
		die('Error creating upload dir');
	}
	return $uploaddir;
}

function get_filepath($map_name) {
	$up_file = $_SERVER['DOCUMENT_ROOT'] . '/bad_uploads/';
	if ($updir = get_upload_dir(ROOT_PATH, $map_name)) {
			$upfile = $updir . basename($_FILES['image']['name']);
	}
	return $upfile;
}

if(move_uploaded_file($_FILES['image']['tmp_name'],get_filepath('uploads'))) {
			echo '<br>Succes!!!<img src="../uploads/' . basename($_FILES['image']['name']) . '" alt="">';
		}
