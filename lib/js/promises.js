function timingOut(msecs) {
	// creating a new deffered object
	var dfd = new jQuery.Deferred();
	setTimeout(function(){
		// Resolving the object after a set time, this means the done method gets called
		dfd.resolve();
	}, msecs);
	return dfd.promise();
}

function showRangeSelector(after) {

	placeRangeWrap();

	$.when(timingOut(after)).done(function() {

		var range = $('#bestOfRange'),
			rangeDisplay = $('.range_display'),
			rangeWrap = $('.range_wrap');

		range.show('slow');

		rangeDisplay.animate({
			'opacity': 1
		});

		$('.close').css({
			'opacity': 1
		});

		rangeWrap.addClass('range_label');

		rangeDisplay.html(range.val());

		$.when(timingOut(2000)).done(function() {

			rangeWrap.addClass('tiny');

			rangeWrap.removeClass('range_label');

			placeTinyRangeWrap();

		});

		range.on('input', function() {
			rangeDisplay.html($(this).val());
		});

		$('.range_wrap .close').on('click', function() {
			rangeWrap.addClass('tiny');
			placeTinyRangeWrap();
			alignThePlusses();
		});

		range.on('change', function() {

			$('#bestOfWrap').load('scripts/update-bestof.php', {'bestOfRange': range.val()}, function() {
				listenForClicks();
				placeRangeWrap();
				alignThePlusses();
			});

		});

		range.on('mouseover', function() {
			$('.tiny').removeClass('tiny');
			range.addClass('range_label');
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
			var counter = "howManyLoads=";
			console.log( getCookieValue(counter));
			var howManyLoads = getCookieValue(counter) || 0;
			howManyLoads++;
			document.cookie = counter + howManyLoads + ";max-age=60";

			// If we're not on the frontpage, none of this should be happening
			if (howManyLoads > 5 || window.location.search !== '') {
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
