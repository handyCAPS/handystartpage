
/**
* Set a timer.
* @param {int} msecs Number of milliseconds the timer runs.
* @return {Object} Returns a thenable promise. Yes that's right.
*/
function timingOut(msecs) {
	// creating a new deffered object
	var dfd = new jQuery.Deferred();
	setTimeout(function(){
		// Resolving the object after a set time, this means the done method gets called
		dfd.resolve();
	}, msecs);
	return dfd.promise();
}



/**
 * Flyout the range selector, then tuck it away
 * @param  {int} after How long to wait before showing
 * @return {void}
 */
function showRangeSelector(after) {
	// Place the element below the bestofs
	placeRangeWrap();

	$.when(timingOut(after)).done(function() {

		var range = $('#bestOfRange'),
			rangeDisplay = $('.range_display'),
			rangeWrap = $('.range_wrap');

		// Slide in the element
		range.show('slow');

		// Showing the help elements
		rangeDisplay.animate({
			'opacity': 1
		});

		$('.close').css({
			'opacity': 1
		});

		// This class has some :after content
		rangeWrap.addClass('range_label');

		// Show current value in the display window
		rangeDisplay.html(range.val());

		// Wait for a bit
		$.when(timingOut(2000)).done(function() {

			// This class shrinks the element
			rangeWrap.addClass('tiny');

			rangeWrap.removeClass('range_label');

			// Tuck the element away in a corner
			placeTinyRangeWrap();

		});

		// As soon as the slider get touched, the display gets updated
		range.on('input', function() {
			rangeDisplay.html($(this).val());
		});

		// The element can be tuck away by the user
		$('.range_wrap .close').on('click', function() {
			// Shrink
			rangeWrap.addClass('tiny');
			// And tuck
			placeTinyRangeWrap();
		});

		/**
		 * When the value changes, on mouseup, two calls to the db are made.
		 * First the layout table gets updated, then a new number of bestofs gets ajaxed in
		 * @return {void}
		 */
		range.on('change', function() {

			updateBestof();

		});

		// Hovering over the small element makes it big again and places it back below the bestofs
		range.on('mouseover', function() {
			$('.tiny').removeClass('tiny');
			placeRangeWrap();
		});

	});

}

function checkCookie(name) {

	var reg = new RegExp(name);

	var cookie = document.cookie;

	var pos = cookie.match(reg);

	if (pos) {
		return pos.index;
	}

	return pos;

}

function getCookieValue(name) {
	var index = checkCookie(name);
	if (index >= 0) {
		return parseFloat(document.cookie.substr(index + name.length));
	}
	return false;
}


function hoverButtonsOnLoad() {

	$.when(timingOut(800)).done(
		// Timer is done, let's do some cool stuff
		function() {

			// Setting a counter to stop this from happening too much
			var counter = "howManyLoads=",
				howManyLoads = getCookieValue(counter) || 0;

			howManyLoads++;

			document.cookie = counter + howManyLoads + ";max-age=60";

			// If we're not on the frontpage, none of this should be happening
			if (howManyLoads > 1 || window.location.search !== '') {
				showRangeSelector(500);
				return this.fail();
			}

			// Grabbing the add-form buttons
			var btn = $('.show-add-form'),
			i = 0,
			len = btn.length,
			biggest = $(btn).offset().left,
			titles =[];
			// Pretending the buttons get hovered
			btn.addClass('hovered');

			// Showing the titles next to the buttons for a bit
			for (;i < len; i++ ) {
				var title = btn[i].title,
				btnID = '#'+ btn[i].id,
				titleID = '#af' + btn[i].id,
				lleft;

				$('body').append('<div class="add-form-title" id="' + titleID.replace('#','') + '">' + title + '</div>');

				// The buttons are on either side of the screen, so they need different styling
				var offleft = $(btnID).offset().left;
				// The one with the biggest offset().left is the one on the right.
				if (offleft > biggest) {
					biggest = offleft;
					lleft = offleft - ($(titleID).innerWidth() + 16);
				} else {
					lleft = offleft + 40;
				}

				$(titleID).animate({
					'top': $(btnID).offset().top - 16,
					'left': lleft,
					'opacity': 1
				});
				// Putting the title div names in an array, so I can remove them later
				titles.push(titleID);
			}

			$.when(timingOut(1200)).done(function() {
				// Unhover
				btn.removeClass('hovered');
				// Cleaning up the title divs
				for(var i = 0; i < titles.length; i++) {
					$(titles[i]).fadeOut(2800);
				}
			});

		}
	);
}
