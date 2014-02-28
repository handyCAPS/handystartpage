<?php

function update_list_forms($db,$cat) {
	$link_array = ask_the_db($db, 'links', '*', "cat_id = $cat", 'link_order');

	$form_string = '';

	foreach ($link_array as $index => $array) {

		foreach ($array as $key => $value) {
			${$key} = $value;
		}
		$idname = strtolower(preg_replace("/[^a-zA-Z]/", '', $name));
		$categories = category_options($db, $cat_id);
		$form_string .= "
		<form method='POST' action='scripts/update-link.php' class='update-list-form'>
			<fieldset>
					<label for='id'>id</label>
					<input type='text' value='$id' name='id' id='id_$idname' class='short' readonly>
					<label for='name'>name</label>
					<input required type='text' value='$name' name='name' id='name_$idname' class='long'>
					<label for='link'>link</label>
					<input required type='text' value='$link' name='link' id='link_$idname' class=''>
					<label for='image'>image</label>
					<input required type='text' value='$image' name='image' id='image_$idname' class='long'>
					<label for='cat_id'>category</label>
					$categories
					<label for='orderid'>link_order</label>
					<input required type='text' value='$link_order' name='link_order' id='link_order_$idname' class='short'>
					<label for='clicks'>clicks</label>
					<input required type='text' value='$clicks' name='clicks' id='clicks_$idname' class='short'>
					<label for='description'>Description</label>
					<textarea name='description' id='description_$idname' class='desc'>$description</textarea>
					<input type='submit' value='Update'>
					<input type='button' value='Delete' class='delete-button'>
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
			<label for='cat_id'>Cat Id</label>
			<input type='number' name='cat_id' value='$cat_id' readonly class='short'>
			<label for='cat_name'>Cat Name</label>
			<input type='text' name='cat_name' value='$cat_name' required class=''>
			<label for='cat_order'>Cat Order</label>
			<input type='text' name='cat_order' value='$cat_order' required class='short'>
			<input type='submit' value='Update'>
				</fieldset>
		</form> ";
		$cat_list .= $cat_form;
	}
	return $cat_list;
}