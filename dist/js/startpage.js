/*! handystartpage - v0.0.1 - 2014-03-12
* Copyright (c) 2014 Tim Doppenberg; Licensed  */
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
			var counter = "howManyLoads=";
			var howManyLoads = getCookieValue(counter) || 0;
			// console.log(document.cookie);
			howManyLoads++;
			document.cookie = counter + howManyLoads + ";max-age=60";
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
$(document).ready(function() {

		var $container = $('#innerWrap');
		$container.masonry({
			itemSelector: '.sub-sections'
		});

		function hideTheForm() {
			var parent = $(this).parents('section'),
			parentId = parent[0].id,
			buttonToShow = '#show' + parentId[0].toUpperCase() + parentId.substr(1);
			parent.fadeOut('fast');
			$(buttonToShow).fadeIn('slow');
		}

		function showAddLinkForm() {
			$('#addLinkForm').fadeIn('slow');
			$('#showAddLinkForm').fadeOut('fast');
			$('#addLinkForm form input:first-of-type').focus();
		}

		function showAddCatForm() {
			$('#addCatForm').fadeIn('slow');
			$('#showAddCatForm').fadeOut('fast');
			$('#addCatForm form input:first-of-type').focus();
		}

		$('a').on('click', function(event) {
			var linkId = event.currentTarget.id.replace(/[^0-9]*/,'');
				$.post('scripts/update-clicks.php?id=' + linkId, function() {
					window.location.reload();
				});
			});

		function alignThePlusses() {
			$('.show-add-form').css({
				'top':  $('#bestof').innerHeight() + 1.5 * $('.show-add-form').outerHeight()
			});
		}

		alignThePlusses();

		$(window).on('resize', alignThePlusses);

		$('.desc').on('focusin', function(event) {
			$(this).animate({
				'height': '+=119px',
				'width': '+=40px'
			});
			if ($(this).html() === 'No Description Available') {
				$(this).select();
			} else {
				event.currentTarget.selectionStart = $(this).html().length;
			}
		});

		$('.desc').on('focusout', function() {
			$(this).animate({
				'height': '-=119px',
				'width': '-=40px'
			});
		});


		$('#showAddLinkForm').on('click', showAddLinkForm);

		$('#showAddCatForm').on('click', showAddCatForm);

		$('.closexWrap').on('click', hideTheForm);

		$('body').on('keypress', function(event) {
			// Hotkey ALT + q to add a link
			if (event.charCode === 113 && event.altKey === true) {
				showAddLinkForm();
			}
			// Hotkey ALT + c to
			else if (event.charCode === 99 && event.altKey === true) {
				showAddCatForm();
			}
		});

		$('.delete-button').on('click', function() {
			if(confirm('Sure ?')) {
				$.post('scripts/delete-link.php?id=' + $(this).siblings('[name="id"]')[0].value , function() {
					window.location.reload();
					});
				}
			});

		$('.clear-clicks').on('click', function(event) {
			if(!confirm('Are you sure you want to reset all the clicks to 0 ?')) {
				event.preventDefault();
			}
		});

		$('input[name="image"]').on('mouseover focusout', function(event) {
			var imgIdName = 'prev' + $(this).parent().context.id;
			var previewImage = "<div class='preview-image' id='" + imgIdName + "'><img src='dist/images/" + $(this)[0].value + "' alt=''></div>";
			var imgId = '#' + imgIdName;
			function showThePreview(preImg, imageId) {
				if (typeof window.$('.preview-image')[0] === 'undefined') {
					if (event.type === "mouseover") {
						$('body').append(preImg);
						$(imageId).css({
							"top": event.pageY - 60,
							"left": event.pageX + 24});
						} else if (event.type === "focusout") {
								$('body').append(preImg);
								$(imageId).css({
									"top": 196,
									"right": 34
								});
						}
				} else {
					$('.preview-image').remove();
					showThePreview(preImg,imgId);
				}
			}
			showThePreview(previewImage,imgId);
		});

		$('input[name="image"]').on('mouseout focusin', function() {
			var imgId = '#prev' + $(this).parent().context.id;
			$(imgId).remove();
		});

	});