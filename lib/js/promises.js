
/**
 * Testdriving the Deferred Object. Set a timer.
 * @param  {int} msecs Number of milliseconds the timer runs.
 * @return {Object}    Returns a thenable promise. Yes that's right.
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
	if (index !== -1) {
		return document.cookie.substr(index + name.length);
	}
	return false;
}


function hoverButtonsOnload() {
	$.when(timingOut(800)).done(
		// Timer is done, let's do some cool stuff
		function() {
			// Setting a counter to stop this from happening too much
			var counter = "TwoManyLoads=";
			var howManyLoads = getCookieValue(counter) || 0;
			howManyLoads++;
			document.cookie = counter + howManyLoads;
			if (howManyLoads > 5) {
				return this.fail();
			}
			// If we're not on the frontpage, none of this should be happening
			if (window.location.search !== '') {
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
				return this.done();
			}).done(function() {
				// Cleaning up the title divs
				for(var i = 0; i < titles.length; i++) {
					$(titles[i]).fadeOut(2800);
				}
			});
		}
	);
}

$(document).ready(hoverButtonsOnload());