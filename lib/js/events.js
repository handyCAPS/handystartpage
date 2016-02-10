

var Switches = {
	editing: false,
	cickTime: 0
};


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

function closeAfterForm() {

	$('#formWrap').animate({
		'min-height': '-=108px'
	}, 'slow');

}

function openForForm() {

	$('#formWrap').animate({
		'min-height': '+=108px'
	}, 'slow');

}


function updateBestof() {

	$('#bestOfWrap').load('scripts/update-bestof.php', {'bestOfRange': $('#bestOfRange').val()}, function() {
		// content get ajaxed in, so eventhandlers need to be reattached
		// If the bestof window gets bigger, the slider needs to be moved
		placeRangeWrap();
		// Same goes for the plusses
		alignThePlusses();
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
	var offsetTop = parseFloat(event.currentTarget.offsetTop);
	var imgIdName = 'prev' + $(this).parent().context.id,
			previewImage =
				"<div class='preview-image' id='" +
				imgIdName +
				"'><img src='" +
				$(this)[0].defaultValue +
				"' alt=''></div>",
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
							"top": offsetTop,
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
	$(document).on('click', 'a[target]', function(event) {
		var link = $(this);
		var linkId = event.currentTarget.id.replace(/[^0-9]*/,'');
			$.post('scripts/update-clicks.php?id=' + linkId, function() {
				updateBestof();
				link.blur();
			});
	});
}

function ajaxUploadImage(el) {

	var previmage = "<div class='previmage'></div>";

	$('body').append(previmage);

	$('.previmage').css({
		'display': 'inline-block',
		'position': 'absolute',
		'top': 24,
		'color': '#FFF',
		'left': '15%'
	});

	var formData = new FormData();

	formData.append('image', $(el.target)[0].files[0]);

	$.ajax({
		url: "scripts/upload-image.php",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(response) {

			console.log($(this));

			var resultObj = JSON.parse(response);

			if (resultObj.hasOwnProperty('uploadErrors')) {
			console.log(resultObj);
			$('.previmage').html(resultObj.uploadErrors);
			return;
			} else {
				var img = "<img src='" + resultObj.imgLocation + resultObj.imgName + "' alt=''>";
				$('.previmage').html(img);
				$('#img_id')[0].value = resultObj.imgId;
			}
		}

	});

}

$('.image-input').on('focusout', function(event) {
	if ($(this).val() !== '' && document.location.search.match(/update/) === null) {
	ajaxUploadImage(event);
	}
});

function scrollPage(){

	if (this.classList.contains('arrow-down')) {

		$('body, html').animate({
			scrollTop: window.scrollMaxY
		});

	} else {

		$('body,html').animate({
			scrollTop: 0
		});

	}

}

$(document).on('click', '.arrow-wrap', scrollPage);

function throttle(func, r) {

	var c = 0;

	var rate = typeof r === 'undefined' ? 20 : r;

	return function() {
		if (c >= rate) {
			func(arguments);
			c = 0;
		} else {
			c++;
		}
	};

}


// $(document).on('click', '.edit-button', function(evt) {
// 	if (Switches.editing) { evt.preventDefault(); }
// });


$(document).on('click', '.catTitle', function(ev) {

	var editButton = $(this),
		link = editButton.parents('a');

	// if (Switches.editing) {

	// 	ev.preventDefault();

	// 	ev.stopPropagation();

		var section = $(this).parents('.sub-sections'),
			containers = section.find('.container');

		if (!Switches.editing) {

			Switches.editing = true;

			section.addClass('sortable');

			containers.addClass('shake');

			section.sortable();

		} else {

			section.removeClass('sortable');

			containers.removeClass('shake');

			$.ajax({
				url: 'scripts/update-order.php',
				data: section.sortable('serialize'),
				success: function(response) {

					var res;

					try {
						res = $.parseJSON(response);
					} catch (e) {
						console.log(e);
						return;
					}

					if (res.success) {

						var checkMark = $('<div>')
										.css({
											position: 'absolute',
											top: '-1.5rem',
											right: '-1rem',
											color: '#0f0',
											fontSize: '3rem',
											pointerEvents: 'none'
										})
										.html('&check;');

						editButton.before( checkMark );

						setTimeout(function() {

							checkMark.fadeOut('slow', function() {
								checkMark.remove();
							});

						}, 2000);

					}

				},
				error: function(response) {
					console.log(response);
				}
			});

			section.sortable('destroy');

			Switches.editing = false;

		}
	// } else {

	// 	window.location = link.attr('href');

	// }

	// $(this).on('mouseup', function(ev) {
	// 	console.log(Date.now() - startTime);
	// 	ev.preventDefault();
	// 	ev.stopPropagation();
	// });

});