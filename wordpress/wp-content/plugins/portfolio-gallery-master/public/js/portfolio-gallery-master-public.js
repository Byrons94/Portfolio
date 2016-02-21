jQuery(document).ready(function($) {
	$('.pgm-portfolio-list > li').each( function() { $(this).hoverdir(); } );
	
	//var from server
	var pgm_display_mode = parseInt( pgm_loc.pgm_display_mode );
	var pgm_per_row = parseInt( pgm_loc.pgm_per_row );
	var pgm_min_width = parseInt( pgm_loc.pgm_min_width );
	var pgm_max_width = parseInt( pgm_loc.pgm_max_width );
	var pgm_init_width = parseInt( pgm_loc.pgm_init_width );
	var pgm_init_height = parseInt( pgm_loc.pgm_init_height );
	var pgm_margin = parseInt( pgm_loc.pgm_margin );
	var pgm_padding = parseInt( pgm_loc.pgm_padding );
	
	//var displayed container
	var cw = parseInt( $('.pgm-portfolio-list').width() ); //container width
	var cr = pgm_init_width / cw; //container/width ratio
	
	//var displayed portfolio
	var dr = pgm_init_height / pgm_init_width; //display h/w ratio
	var dw; //display width
	var dh; //display height
	var mpx; //margin to px
	var ppx; //padding to px
	var cp; //container padding to center the portfolio gallery
	
	var pgm_resize;
	
	if ( pgm_display_mode == 3 ){
		dw = parseInt( ( cw / pgm_per_row / ( 1 + (  pgm_margin / 50 ) ) - 0.5 ).toFixed(1) );
		
		if ( !isNaN(pgm_min_width) && dw < pgm_min_width ){
			dw = pgm_min_width;
		} else if( !isNaN(pgm_max_width) && dw > pgm_max_width ) {
			dw = pgm_max_width;
		}

		dh = dr * dw;
		mpx = dw * pgm_margin / 100;
		ppx = dw * pgm_padding / 100;
		cp = parseInt( ( ( ( cw % ( ( 2 * mpx + dw ) ) ) / 2 ) - 1).toFixed() );

		$('.pgm-portfolio-list').css('padding', "0 " + cp + "px");
		$('.pgm-portfolio-list-item').css('width', dw).css('height', dh).css('margin', mpx + "px").css('padding', ppx + "px");

		$(window).resize(function(){
			clearTimeout(pgm_resize);
			pgm_resize = setTimeout(resizeModeThree, 100); //Delay 100 milliseconds until the next resize is detected
			return false;
		});
	} else { 
		if ( cw < pgm_init_width ){ //if gallery item is bigger than the container
			dw = cw / ( 1 + (pgm_margin / 50) );
			dh = dr * cw;
			//width to container will set to 1
			cr = 1;
		} else {
			dw = pgm_init_width;
			dh = pgm_init_height;
		}
		mpx = dw * pgm_margin / 100;
		ppx = dw * pgm_padding / 100;
		//calculate padding for ul to center the gallery
		cp = parseInt( (( ( cw % ( ( 2 * mpx + dw ) ) ) / 2 ) - 1).toFixed() );
		$('.pgm-portfolio-list').css('padding', "0 " + cp + "px");
		$('.pgm-portfolio-list-item').css('width', dw).css('height', dh).css('margin', mpx + "px").css('padding', ppx + "px");
		
		if ( pgm_display_mode == 1 ) {
			$(window).resize(function(){
				clearTimeout(pgm_resize);
				pgm_resize = setTimeout(resizeModeOne, 100); //Delay 100 milliseconds until the next resize is detected
				return false;
			});
		} else {
			dr = dh / dw; //set display h to w ratio
			$(window).resize(function(){
				clearTimeout(pgm_resize);
				pgm_resize = setTimeout(resizeModeTwo, 100); //Delay 100 milliseconds until the next resize is detected
				return false;
			});
		}
		
	}
	
	
	//Mode: Fixed
	function resizeModeOne(){
		cw = parseInt( $('.pgm-portfolio-list').width() ) + ( cp * 2 );
		cp = parseInt( ( ( ( cw % ( ( 2 * mpx + dw ) ) ) / 2 ) - 1).toFixed() );

		$('.pgm-portfolio-list').css('padding', "0 " + cp + "px");
		$('.pgm-portfolio-list-item').css('width', dw).css('height', dh).css('margin', mpx + "px").css('padding', ppx + "px");
	}
	
	//Mode: Auto Resize
	function resizeModeTwo(){
		cw = parseInt( $('.pgm-portfolio-list').width() ) + ( cp * 2 );
		dw = cr * cw / ( 1 + (  pgm_margin / 50 ) );
		dh = dr * dw;
		mpx = dw * pgm_margin / 100;
		ppx = dw * pgm_padding / 100;
		cp = parseInt( ( ( ( cw % ( ( 2 * mpx + dw ) ) ) / 2 ) - 1).toFixed() );

		$('.pgm-portfolio-list').css('padding', "0 " + cp + "px");
		$('.pgm-portfolio-list-item').css('width', dw).css('height', dh).css('margin', mpx + "px").css('padding', ppx + "px");
	}
	
	//Mode: Portfolios per Row
	function resizeModeThree(){
		cw = parseInt( $('.pgm-portfolio-list').width() ) + ( cp * 2 );
		dw = parseInt( ( cw / pgm_per_row / ( 1 + (  pgm_margin / 50 ) ) - 1 ).toFixed() );
		
		if ( !isNaN(pgm_min_width) && dw < pgm_min_width ){
			dw = pgm_min_width;
		} else if( !isNaN(pgm_max_width) && dw > pgm_max_width ) {
			dw = pgm_max_width;
		}
		
		dh = dr * dw;
		mpx = dw * pgm_margin / 100;
		ppx = dw * pgm_padding / 100;
		cp = parseInt( ( ( ( cw % ( ( 2 * mpx + dw ) ) ) / 2 ) - 1 ).toFixed() );

		$('.pgm-portfolio-list').css('padding', "0 " + cp + "px");
		$('.pgm-portfolio-list-item').css('width', dw).css('height', dh).css('margin', mpx + "px").css('padding', ppx + "px");
	}
});
