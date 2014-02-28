/*! handystartpage - v0.0.1 - 2014-02-27
* Copyright (c) 2014 Tim Doppenberg; Licensed  */
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
				$.post('scripts/update-clicks.php?id=' + event.currentTarget.id, function() {
					window.location.reload();
				});
			});

		$('#showAddLinkForm').on('click', showAddLinkForm);

		$('#showAddCatForm').on('click', showAddCatForm);

		$('.closexWrap').on('click', hideTheForm);

		$('body').on('keypress', function(event) {
			// Hotkey ALT + q
			if (event.charCode === 113 && event.altKey === true) {
				showAddLinkForm();
			}
			// Hotkey ALT + c
			else if (event.charCode === 99 && event.altKey === true) {
				showAddCatForm();
			}
		});

		$('.delete-button').on('click', function() {
			if(confirm('Sure ?')) {
				$.post('scripts/delete-link.php?id=' + $(this).siblings('[name="id"]')[0].value , function() {
					window.reload();
					});
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

		$('input[name="image"]').on('mouseout focusin', function(event) {
			var imgId = '#prev' + $(this).parent().context.id;
			$(imgId).remove();
		});

		$('#description').on('focusin', function() {
			$(this).animate({
				'height': '+=119px',
				'width': '+=40px'
			});
		});
		$('#description').on('focusout', function() {
			$(this).animate({
				'height': '-=119px',
				'width': '-=40px'
			});
		});
	});