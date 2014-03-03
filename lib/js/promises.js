function timingOut(msecs) {
	var dfd = new jQuery.Deferred();
	setTimeout(function(){
		dfd.resolve();
	}, msecs);
	return dfd.promise();
}

$.when(timingOut(800)).done(
		function() {
			var btn = $('.show-add-form'),
			i = 0,
			len = btn.length,
			biggest = $(btn).offset().left,
			titles =[];

			btn.addClass('hovered');

			for (;i < len; i++ ) {
				// console.log(biggest);
				var title = btn[i].title,
				btnID = '#'+ btn[i].id,
				titleID = '#af' + btn[i].id;

				$('body').append('<div class="add-form-title" id="' + titleID.replace('#','') + '">' + title + '</div>');

				var offleft = $(btnID).offset().left;

				if (offleft > biggest) {
					biggest = offleft;
					lleft = offleft - ($(titleID).innerWidth() + 16);
				} else {
					lleft = offleft + 40;
				}

				$(titleID).css({
					'top': $(btnID).offset().top - 8,
					'left': lleft,
					'opacity': 1
				});

				titles.push(titleID);
			};

			$.when(timingOut(1200)).done(function() {
				btn.removeClass('hovered');
			}).done(function() {
				for(var i = 0; i < titles.length; i++) {
					$(titles[i]).slideUp(1500);
				}
			});
		}
	);