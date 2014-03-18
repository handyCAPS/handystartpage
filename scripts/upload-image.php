<?php

require_once 'db/connection.php';
require_once 'query.php';

require_once 'class.fileupload.php';

$upload = new Image_Upload();

if (!isset($_FILES['image'])) {
	die();
}
$result = $upload->upload($_FILES['image']);

if ($result['state']) {

	$mime = $result['mime'];
	$name = $result['name'];
	$location = $result['location_rel'];

	$db_result = add_to_the_db($db, 'images', "img_name, img_mime, img_location", "'$name', '$mime', '$location' ");

	$img =
		"<img src='"
		. $result['location_rel']
		. $result['name']
		. "' alt=''>";

	$info = array(
			'imgName' => $name,
			'imgLocation' => $location,
			'imgId' => $db->insert_id
		);

	echo json_encode($info);

} else {
	$upload_errors = array('uploadErrors' => $result['upload_errors']);
	echo json_encode($upload_errors);
}

