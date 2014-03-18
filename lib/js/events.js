
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
	var offsetTop = parseFloat(event.currentTarget.offsetTop);
	var imgIdName = 'prev' + $(this).parent().context.id,
			previewImage =
				"<div class='preview-image' id='" +
				imgIdName +
				"'><img src='dist/images/" +
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
