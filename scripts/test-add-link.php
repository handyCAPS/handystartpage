<?php

// require_once 'util.php';

// function get_upload_dir($root_map, $map_name) {
// 	$uploaddir = FALSE;
// 	if (!is_dir($uploaddir = $root_map . "/$map_name/")){
// 		if (chdir($root_map)) {
// 			if (mkdir($map_name)) {
// 				get_upload_dir($root_map, $map_name);
// 			}
// 		}
// 	}
// 	return $uploaddir;
// }

// function get_filepath($map_name) {
// 	$up_file = $_SERVER['DOCUMENT_ROOT'] . '/bad_uploads/';
// 	if ($updir = get_upload_dir(ROOT_PATH, $map_name)) {
// 			$upfile = $updir . basename($_FILES['image']['name']);
// 	}
// 	return $upfile;
// }

// if(move_uploaded_file($_FILES['image']['tmp_name'],get_filepath('uploads'))) {
// 			echo '<br>Succes!!!<img src="../uploads/' . basename($_FILES['image']['name']) . '" alt="">';
// 		}

include 'test.fileupload.php';