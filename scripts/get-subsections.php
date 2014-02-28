<?php

/**
 * Format the links and return an array of strings of html elements
 * to display a row of images that are clickable links
 * @param  Object $db         The db connection
 * @param  Array $full_array  All the link info
 * @param  Integer $cat_id    The id of the category
 * @return Array              An array of strings containing html elements
 */
function get_the_links($db, $full_array, $cat_id) {
	$link_array = array();
	$link = '';
	foreach ($full_array as $key => $assoc) {
		if ($assoc['cat_id'] === $cat_id) {
			$link = "<div class='container'><a href='"
			. $assoc['link']
			. "' target='_blank' id='"
			. $assoc['id']
			. "'><div class='flipper'><img src='dist/images/"
			. $assoc['image']
			. "' alt='"
			. $assoc['name']
			. "' title='"
			. $assoc['name']
			. " ["
			. $assoc['link_order']
			. "]'><div class='description'><p>"
			. $assoc['description']
			. "</p></div></div></a></div>" ;
			array_push($link_array, $link);
		}
	}
	return $link_array;
}

/**
 * Group the links together, sorted by category
 * @param  Object $db         The db connection
 * @param  Array $full_array  All the link info
 * @param  Array $cat_array   The categories
 * @return Array              An array of arrays of links
 */
function array_the_links($db, $full_array, $cat_array) {
	$cat_link_array = array();
	for ($j = 0; $j < count($cat_array); $j++) {
		$links = get_the_links($db, $full_array, $cat_array[$j]['cat_id']);
		array_push($cat_link_array, $links);
	}
	return $cat_link_array;
}

function get_the_sub_sections($db, $cat_array, $all_the_links) {
	$subsec_string = '';
	for ($m = 0; $m < count($cat_array); $m++) {
		$sub_section =
		  "<div class='sub-sections'><a href='?update=links&amp;category="
		. $cat_array[$m]['cat_id']
		. "'><div class='edit-button' data-catid='"
		. $cat_array[$m]['cat_id']
		. "'></div></a><h2>"
		. $cat_array[$m]['cat_name']
		. "</h2><p>";
		foreach ($all_the_links as $key => $value) {
			if ($key === $m) {
				$sub_section .= implode("", $value);
			}
		}
		$sub_section .= "</p></div>";
		$subsec_string .= $sub_section;
	}
	return $subsec_string;
}

function get_subsection_string($db) {
	$full_array = ask_the_db($db, 'links, categories', '*', 'links.cat_id = categories.cat_id', 'cat_order, link_order');

	$cat_array = ask_the_db($db, 'categories', 'cat_id, cat_name', '', 'cat_order');

	$all_the_links = array_the_links($db, $full_array, $cat_array);

	$subset_string = get_the_sub_sections($db, $cat_array, $all_the_links);

	return $subset_string;
}


