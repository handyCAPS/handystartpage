<?php
function get_cat_name($db, $category) {

	/** Asking the db for the category name.
	 * The ask_the_db function always returns an array of associative arrays.
	 * This should probably not be the case if there's only one answer
	*/
	$cat_nameA = ask_the_db($db, 'categories', 'cat_name', 'cat_id = ' . $category);

	/**
	 * Since there's only one answer to the db question,
	 * the category name is onder the first index
	*/
	return $cat_name = $cat_nameA[0]['cat_name'];
}