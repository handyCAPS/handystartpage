<?php

/**
 * Get the 10 most clicked links from the db
 * @param  Object $db 						The db connection
 * @param  Int 		$n 							Number of links to return
 * @return string $bestof_string	String containing html elements
 */
function get_bestof($db, $n = 13) {
	$bestof_string = '';
	$results = ask_the_db($db, 'links', '*','', 'clicks', 'DESC', $n);
	foreach ($results as $key => $array) {
		$link = "<div class='container'><a href='"
		. $array['link']
		. "' target='_blank' id='best"
		. $array['id']
		. "'><div class='flipper'><img src='dist/images/"
		. $array['image']
		. "' alt='"
		. $array['name']
		. "' title='"
		. $array['name']
		. " ["
		. $array['clicks']
		. "]'><div class='description'>"
		. $array['description']
		. "</div></div></a></div>";
		$bestof_string .= $link;
	}
	return $bestof_string;
}