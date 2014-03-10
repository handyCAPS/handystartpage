<?php

require_once 'db/connection.php';

/**
 * Get the path to the img upload map, make it if not there
 * @param  string 			$root_map		Path to the root folder
 * @param  string 			$map_name		Name of the map where the file gets stored
 * @return string/bool 	$uploaddir 
 */
function get_upload_dir($root_map, $map_name) {
	$uploaddir = FALSE;
	if(!is_dir($uploaddir = $root_map . "/$map_name/")){
		if (chdir($root_map)) {
			if (mkdir($map_name)) {
				get_upload_dir($root_map, $map_name);
			}
		}
	}
	return $uploaddir;
}

/**
 * Get the path where the uploaded file can be stored
 * @param  string 			$map_name				Name of the map where the file gets stored
 * @param  string 			$uploaded_file	Name of the uploaded file
 * @return string/bool 	$upfile					Path to store the file under
 */
function get_filepath($map_name, $uploaded_file) {
	$up_file = FALSE;
	if ($updir = get_upload_dir(ROOT_PATH, $map_name)) {
			$upfile = $updir . $uploaded_file;
	}
	return $upfile;
}

Class File_upload {
	private static $img_dir = 'uploads';

}

if ($filepath = get_filepath('uploads', basename($_FILES['image']['name']))) {
	if(move_uploaded_file($_FILES['image']['tmp_name'], $filepath)) {
				echo '<br>Succes!!! ' . $_FILES['image']['size'];
			}
}
