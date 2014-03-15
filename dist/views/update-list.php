<?php
require_once 'scripts/get-cat-name.php';
$category = $_REQUEST['category'];
?>

<h1><?php echo get_cat_name($db, $category); ?></h1>

<a href="index.php">
	<div id="home"></div>
</a>
<a href="scripts/clear-clicks.php?category=<?php echo $category; ?>" title='Reset clicks to 0'>
	<div class="clear-clicks">Clear Clicks</div>
</a>

<?php echo update_list_forms($db, $category); ?>