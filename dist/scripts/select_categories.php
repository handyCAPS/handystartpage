<?php

// require_once 'query.php';

function get_the_cat_options($db) {
	// $cat_select_array = array();
	$cats = ask_the_db($db, 'categories', '*', '', 'cat_order');
	$select = "<select name='cat_id' id='cat_id'>";
	foreach ($cats as $index => $cat) {
		$select .= "<option value='" . $cat['cat_id'] . "'>" . $cat['cat_name'] . "</option>";
	}
	$select .= "</select>";
	// array_push($cat_select_array, $select);
	return $select;
}