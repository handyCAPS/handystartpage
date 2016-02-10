<?php

	require_once 'scripts/get-bestof.php';

?>

<div class="sub-sections wide" id='bestof'>
	<h2>Best Of</h2>
	<div class="range_wrap">
		<div class="range_display">13</div>
		<input type="range" min='10' max='64' value="<?php echo $num_best; ?>" name='bestOfRange' id='bestOfRange' title='Select number of bestofs. From 10 to 60'>
		<div class='close'></div>
	</div><!--  end .range_wrap  -->
	<div id='bestOfWrap'>
		<?php
		echo get_bestof($db);
		?>
	</div>
</div>
