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