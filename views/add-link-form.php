<div id="showAddLinkForm" title="Add a link" class="show-add-form"></div>
<section class="form add-form" id='addLinkForm' enctype="multipart/form-data">
	<form action="scripts/add-link.php" method="POST">
	<fieldset>
		<legend>Add new Link</legend>
		<label for="link">Link</label>
		<input type="text" id="link" name="link" class="long" required>
		<label for="image">Image</label>
		<input type="text" id="image" name="image" class="medium" required>
		<!-- <input type="file" id="image" name="image" class="medium"> -->
		<label for="name">Name</label>
		<input type="text" id="name" name="name" class="medium" required>
		<label for="cat_id">Category</label>
		<?php
		echo category_options($db);
		?>
		<label for="description">Description</label>
		<textarea name="description" id="description" class="desc"></textarea>
		<label for="link_order">Order</label>
		<input type="number" id="link_order" name="link_order" class="short" required>
		<input type="submit" value="submit">
		<div class="closexWrap"><span class="closex"></span></div>
	</fieldset>
	</form>
</section><!--  end #addLinksForm  -->