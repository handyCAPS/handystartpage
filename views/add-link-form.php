
<section class='form add-form' id='addLinkForm'>
	<form action='scripts/add-link.php' method='POST' enctype='multipart/form-data'>
	<fieldset>
		<legend>Add new Link</legend>
		<label for='link'>Link</label>
		<input type='text' id='link' name='link' class='long' required>
		<label for='image'>Image</label>
		<input type='file' id='image' name='image' class='medium'>
		<input type="hidden" name="img_id" id="img_id" value="">
		<label for='name'>Name</label>
		<input type='text' id='name' name='name' class='medium' required>
		<label for='cat_id'>Category</label>
		<?php echo category_options($db); ?>
		<label for='description'>Description</label>
		<textarea name='description' id='description' class='desc'></textarea>
		<label for='link_order'>Order</label>
		<input type='number' id='link_order' name='link_order' class='short' required>
		<input type='submit' value='submit'>
		<div class='closexWrap'><span class='closex'></span></div>
	</fieldset>
	</form>
</section><!--  end #addLinksForm  -->