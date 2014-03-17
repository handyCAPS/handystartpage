/*! handystartpage - v0.0.1 - 2014-03-17
* Copyright (c) 2014 Tim Doppenberg; Licensed  */

function hideTheForm(el) {

	var parent = el.parents('section'),
	parentId = parent[0].id,
	buttonToShow = '#show' + parentId[0].toUpperCase() + parentId.substr(1);

	parent.hide('fast');

	$(buttonToShow).fadeIn('slow');
}

function showAddLinkForm() {
	$('#addLinkForm').slideDown('slow');
	$('#showAddLinkForm').fadeOut('fast');
	$('#addLinkForm form input:first-of-type').focus();
}

function showAddCatForm() {
	$('#addCatForm').slideDown('slow');
	$('#showAddCatForm').fadeOut('fast');
	$('#addCatForm form input:first-of-type').focus();
}

function alignThePlusses() {
	$('.show-add-form').css({
		'top':  $('#bestof').innerHeight() + 1.5 * $('.show-add-form').outerHeight()
	});
}

function placeRangeWrap() {
	$('.range_wrap').css({
		'top': $('#bestof').outerHeight(),
		'right': 0
			});
}

function placeTinyRangeWrap() {
	$('.range_wrap').css({
		'top': '-8px',
		'right': '-80px'
	});
}

$(window).on('resize', function() {
	alignThePlusses();
});

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

function closeAfterForm() {

	$('#formWrap').animate({
		'height': '-=108px'
	}, 'slow');

}

function openForForm() {

	$('#formWrap').animate({
		'height': '+=108px'
	}, 'slow');

}

$('.closexWrap').on('click', function() {
	var clicked = $(this);
	hideTheForm(clicked);
	closeAfterForm();
});

$('#showAddLinkForm').on('click', function () {

	openForForm();
	showAddLinkForm();

});

$('#showAddCatForm').on('click', function() {

	openForForm();
	showAddCatForm();

});



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

	var imgIdName = 'prev' + $(this).parent().context.id,
			previewImage = "<div class='preview-image' id='" + imgIdName + "'><img src='dist/images/" + $(this)[0].value + "' alt=''></div>",
			imgId = '#' + imgIdName;

	function showThePreview(preImg, imageId) {
		var update = window.location.search.match("update");
		if (typeof window.$('.preview-image')[0] === 'undefined') {
			$('body').append(preImg);
			if (event.type === "mouseover") {
				$(imageId).css({
					"top": event.pageY - 60,
					"left": event.pageX + 24});
				} else if (event.type === "focusout" && !update) {
						$(imageId).css({
							"top": 208,
							"right": 12
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

function listenForClicks() {
	$('a').on('click', function(event) {
		var linkId = event.currentTarget.id.replace(/[^0-9]*/,'');
			$.post('scripts/update-clicks.php?id=' + linkId, function() {
				window.location.reload();
			});
	});
}

function get_the_file() {
	$('#image').on('focusout', function() {
		var testdiv = "<div class='testdiv'></div>";
		$('body').append(testdiv);
		$('.testdiv').css({
			'display': 'inline-block',
			'background-color': '#CCC',
			'position': 'absolute',
			'top': 20
		});

		var formData = new FormData();

		formData.append('image', $('#image')[0].files[0]);

		$.ajax({
			url: "scripts/upload-image.php",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function(response) {
				$('.testdiv').html(response);
			}

		});

	});
}

get_the_file();

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