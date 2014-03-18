<?php

require_once 'db/connection.php';
require_once 'query.php';

require_once 'class.fileupload.php';

$upload = new Image_Upload();

$result = $upload->upload($_FILES['image']);

if ($result['state']) {
	$img =
		"<img src='"
		. $result['location_rel']
		. $result['name']
		. "' alt=''>";

	echo $img;

}

// var_dump($result);