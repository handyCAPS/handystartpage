<?php
/**
 * Query the db and build an array of names and ids
 * @param  Object $db The db connection
 * @return Array $cat_array Array of assoc arrays ordered by order_id
 */
function get_the_categories($db) {
	$cat_array = ask_the_db($db, 'categories', '*', '', 'cat_order');
	return $cat_array;
}

/**
 * Put all the categories into a nice little selectbox
 * @param  Object $db          The db connection
 * @param  string $current_cat Optional. Cat_id of category to be marked as selected
 * @return string              Html elements to display a selectbox containing all the categories
 */
function category_options($db, $current_cat = '') {
	$cat_array = get_the_categories($db);
	if ($current_cat === '') {
		$selected_cat = $cat_array[0]['cat_id'];
	} else {
		$selected_cat = $current_cat;
	}
	$select_string = "<select name='cat_id' id='cat_id'>";
	foreach ($cat_array as $index => $assoc) {
		if ($selected_cat === $assoc['cat_id']) {
			$selected = ' selected';
		} else {
			$selected = '';
		}
		$select_string .= "<option value='"
			. $assoc['cat_id']
			. "'"
			. $selected
			. ">"
			. $assoc['cat_name']
			. "</option>";
	}
	$select_string .= "</select>";

	return $select_string;
}