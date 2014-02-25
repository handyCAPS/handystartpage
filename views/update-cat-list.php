<?php

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

echo "<h1>Categories</h1>";
echo '<a href="index.php"><div id="home"></div></a>';
echo list_the_categories($db);