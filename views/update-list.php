<?php

/**
 * Checking if the category id is set and storing it.
 * Although if it wasn't set, you wouldn't be seeing this page.
 * Anyway, always best to check.
*/
$category = isset($_REQUEST['category']) ? $_REQUEST['category'] : 1;

/** Asking the db for the category name.
 * The ask_the_db function always returns an array of associative arrays.
 * This should probably not be the case if there's only one answer
*/
$cat_nameA = ask_the_db($db, 'categories', 'cat_name', 'cat_id = ' . $category);

/**
 * Since there's only one answer to the db question,
 * the category name is onder the first index
*/
$cat_name = $cat_nameA[0]['cat_name'];

echo "<h1>$cat_name</h1>";
echo '<A href="index.php"><div id="home"></div></a>';

function list_the_list_forms($db, $cat) {

	$sql = "SELECT * FROM links WHERE cat_id='$cat' ORDER BY link_order ";
	$results = $db->query($sql);
	;
	while($row = $results->fetch_assoc()) {
		foreach ($row as $key => $value) {
			${$key} = $value;
		}
		$idname = strtolower(preg_replace("/[^a-zA-Z]/", '', $name));
		$categories = category_options($db, $cat_id);
		$update_list_form = "
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
				<input type='submit' value='Update'>
				<input type='button' value='Delete' class='delete-button'>
				</fieldset>
		</form>
			";

		echo $update_list_form;
	}
}
list_the_list_forms($db, $category);


