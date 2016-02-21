jQuery(document).ready(function($) {
	$(".progress-bar").each(function() {
		$(this).width($(this).data('level') + '%');
	});
});