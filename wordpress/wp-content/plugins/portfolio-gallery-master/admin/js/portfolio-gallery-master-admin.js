jQuery(document).ready(function( $ ) {
	$(".pgm-shortcode-display").click(function(){
		this.select();
		return false;
	});
	
	$("input[name=pgm_portfolio_display_mode]:radio").click(function(){
		var mode = $("input[name=pgm_portfolio_display_mode]:checked").val();
		
		if( mode == 3 ){
			$("input.pgm_portfolio_display_mode_input").prop('disabled', false);
		} else {
			$("input.pgm_portfolio_display_mode_input").prop('disabled', true);
		}
		
	});
	
	$("#pgm_portfolio_frame_color").minicolors({
		animationSpeed: 50,
		animationEasing: 'swing',
		change: null,
		changeDelay: 0,
		control: 'hue',
		dataUris: true,
		defaultValue: 'rgb(255, 255, 255)',
		format: 'rgb',
		hide: null,
		hideSpeed: 100,
		inline: false,
		keywords: '',
		letterCase: 'lowercase',
		opacity: true,
		position: 'top	right',
		show: null,
		showSpeed: 100,
		theme: 'default'
	});

	$("#pgm_portfolio_overlay_font_color").minicolors({
		animationSpeed: 50,
		animationEasing: 'swing',
		change: null,
		changeDelay: 0,
		control: 'hue',
		dataUris: true,
		defaultValue: '#000000',
		format: 'hex',
		hide: null,
		hideSpeed: 100,
		inline: false,
		keywords: '',
		letterCase: 'lowercase',
		opacity: false,
		position: 'top	right',
		show: null,
		showSpeed: 100,
		theme: 'default'
	});
	
	$("#pgm_portfolio_overlay_color").minicolors({
		animationSpeed: 50,
		animationEasing: 'swing',
		change: null,
		changeDelay: 0,
		control: 'hue',
		dataUris: true,
		defaultValue: 'rgba(0, 0, 0, 0.7)',
		format: 'rgb',
		hide: null,
		hideSpeed: 100,
		inline: false,
		keywords: '',
		letterCase: 'lowercase',
		opacity: true,
		position: 'top	right',
		show: null,
		showSpeed: 100,
		theme: 'default'
	});

});