<?php

function list_the_links($db) {
	$sql = "SELECT * FROM links order by link_order";
	$results = $db->query($sql);
	$forms = '';

	while ($row = $results->fetch_assoc()) {
		foreach ($row as $key => $value) {
			${$key} = $value;
		}

		$link_form = "
			<form method='POST' action='scripts/update-link.php' id='listForm'>
				<fieldset>
					<legend></legend>
					<input type='text' name='id' id='id' value='$id' class='short' readonly>
					<label for='name'>Name</label>
					<input type='text' name='name' id='name' class='' value='$name'>
					<label for='link'>link</label>
					<input type='text' name='link' id='link' class='' value='$link'>
					<label for='image'>image</label>
					<input type='text' name='image' id='image' class='medium' value='$image'>
					<label for='category'>category</label>
					<input type='text' name='category' id='category' class='medium' value='$category'>
					<label for='orderid'>orderid</label>
					<input type='number' name='orderid' id='orderid' class='short' value='$orderid'>
					<label for='clicks'>clicks</label>
					<input type='number' name='clicks' id='clicks' class='short' value='$clicks'>
					<input type='submit' value='update'>
				</fieldset>
			</form>
		 ";
	 if ($row['category'] === 'Tools') {
	 	$forms .= $link_form;
	 }
	}
	return $forms;
}
?>

