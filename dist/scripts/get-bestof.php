<?php

require_once 'layout.php';

/**
 * Get the 10 most clicked links from the db
 * @param  Object $db 						The db connection
 * @param  Int 		$n 							Number of links to return
 * @return string $bestof_string	String containing html elements
 */
function get_bestof($db) {

	$num_best = get_num_bestof($db);

	if (!is_numeric($num_best)) {
		$num_best = 13;

		if (DEBUG){
			echo 'Result of asking db table layout: <br>';
			var_dump($num_best);
			return;
		}

	}

	$bestof_string = '';

	$results = ask_the_db($db, 'links, images', '*','links.img_id = images.img_id', 'clicks', 'DESC', $num_best);
	if (!is_array($results)) {

		if (DEBUG) {
			echo 'Result of asking db table links: <br>';
			var_dump($results);
			return;
			}

	} else {
		foreach ($results as $key => $array) {
			$link = "<div class='container'><a href='"
			. $array['link']
			. "' target='_blank' id='best"
			. $array['id']
			. "'><div class='flipper'><img src='"
			.	$array['img_location']
			. $array['img_name']
			. "' alt='"
			. $array['name']
			. "' title='"
			. $array['name']
			. " ["
			. $array['clicks']
			. "]'><div class='description'><p>"
			. $array['description']
			. "</p></div></div></a></div>";
			$bestof_string .= $link;
		}
	}
	return $bestof_string;
}

$num_best = get_num_bestof($db);