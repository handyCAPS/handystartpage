
<section id="addCatForm" class="add-form">
	<form method="POST" action="scripts/add-category.php">
		<fieldset>
			<legend>Add category</legend>
			<label for="cat_name">Name</label>
			<input type="text" id="cat_name" name="cat_name">
			<label for="cat_order">Order</label>
			<input type="text" id="cat_order" name="cat_order" class="short">
			<input type="submit" value="Add">
			<div class="closexWrap"><span class="closex"></span></div>
		</fieldset>
	</form>
	<a href="?update=cats"><div id="listCat">Update</div></a>
</section>