<?php

<?php

require_once 'db/connection.php';
require_once 'query.php';

// foreach ($_POST as $key => $value) {
// 	${$key} = $db->real_escape_string($value);
// }
// $link = urlencode($link);

function get_image_id($db) {

	// if the image was not uploaded or add to the db, return false
	$img_id = FALSE;

	if (isset($_FILES['image'])) {
		require_once 'class.fileupload.php';

		$image = $_FILES['image'];

		$upload = new Image_Upload();

		$img_result = $upload->upload($image);

		if ($img_result['state']) {
			// image was succesfully uploaded
			$img_name = $img_result['name'];
			$img_mime = preg_replace('/image\//', '', $img_result['mime']);
			$img_location = $img_result['location_rel'];

			$db_result = add_to_the_db($db, 'images', 'img_name, img_mime, img_location', "'$img_name', '$img_mime', '$img_location'");

			if ($db_result === TRUE) {
				// image was succesfully added to the db, so there is an img_id generated
				$img_id = $db->insert_id;
			}

			if (DEBUG && $db_result !== TRUE) {
				var_dump($db_result);
				return;
			}

		} else {
			if (isset($img_result['upload_errors']) && is_array($img_result['upload_errors'])) {
					// image upload returned errors
					$img_id = $img_result['upload_errors'];
				}
			}
	}

	return $img_id;

}

function update_link($db) {

	$name 				= $_POST['name'];
	$link 				= $_POST['link'];
	$link_order 	= $_POST['link_order'];
	$cat_id 			= $_POST['cat_id'];
	$clicks 			= $_POST['clicks'];
	$description 	= $_POST['description'];
	$id 					= $_POST['id'];
	$image 				= "";

	if ($img_id = get_image_id($db)) {
		if (is_array($img_id)) {
			$errors = implode("", $img_id);
		} else {
			$image = "img_id='$img_id', ";
		}
	}

	if ($db_result = update_the_db($db, 'links', "name='$name', link='$link', link_order='$link_order', cat_id='$cat_id', $image clicks='$clicks', description='$description'", "id='$id'")) {
		header('Location:../?update=links&category=' . $cat_id);
	} else {
		if (DEBUG) {
			var_dump($db_result);
			return;
		}
		echo 'There was a problem updating the database. <a href="../">Home</a>';
	}

}

update_link($db);
