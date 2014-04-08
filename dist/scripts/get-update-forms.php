<?php

function update_list_forms($db,$cat) {
	$link_array = ask_the_db($db, 'links, images', '*', "links.cat_id = $cat AND links.img_id = images.img_id", 'link_order');

	$form_string = '';

	foreach ($link_array as $index => $array) {

		foreach ($array as $key => $value) {
			${$key} = $value;
		}
		$idname = strtolower(preg_replace("/[^a-zA-Z]/", '', $name));
		$categories = category_options($db, $cat_id);
		$set_image = $img_location . $img_name;
		$form_string .= "
		<form enctype='multipart/form-data' method='POST' action='scripts/update-link.php' class='update-list-form'>
			<fieldset>
					<input type='hidden' value='$id' name='id' id='id_$idname'>
					<input required type='text' value='$name' name='name' id='name_$idname' class='long'>
					<label for='orderid'>ord</label>
					<input required type='text' value='$link_order' name='link_order' id='link_order_$idname' class='short'>
					<label for='link'>link</label>
					<input required type='text' value='$link' name='link' id='link_$idname' class='long'>
					<label for='image'>img</label>
					<input type='file' name='image' id='image_$idname' class='medium image-input' value='$set_image'>
					<input type='hidden' name='img_id' id='img_id_$idname' value=''>
					<label for='description'>desc</label>
					<textarea name='description' id='description_$idname' class='desc'>$description</textarea>
					<label for='cat_id'>cat</label>
					$categories
					<label for='clicks'>clicks</label>
					<input required type='text' value='$clicks' name='clicks' id='clicks_$idname' class='short'>
					<input type='submit' value='Update'>
					<button type='button' value='Delete' class='delete-button' title='Delete Link'>
					</fieldset>
			</form>
		";
	}
	return $form_string;
}

function list_the_categories($db) {
	$cat_array = get_the_categories($db);
	$cat_list = '';
	foreach ($cat_array as $key => $assoc) {
		foreach ($assoc as $key => $value) {
			${$key} = $value;
		}
		$cat_form = "<form action='scripts/update-cats.php' method='POST' class='update-list-form'>
			<fieldset>
			<label for='cat_id'>ID</label>
			<input type='number' name='cat_id' value='$cat_id' readonly class='short'>
			<label for='cat_name'>Name</label>
			<input type='text' name='cat_name' value='$cat_name' required class=''>
			<label for='cat_order'>Order</label>
			<input type='text' name='cat_order' value='$cat_order' required class='short'>
			<input type='submit' value='Update'>
				</fieldset>
		</form> ";
		$cat_list .= $cat_form;
	}
	return $cat_list;
}