

$(document).ready(function() {

	var $container = $('#innerWrap');
	$container.masonry({
		itemSelector: '.sub-sections'
	});

	alignThePlusses();

	hoverButtonsOnLoad();

	showRangeSelector(5000);

	listenForClicks();

});