jQuery(document).ready( function(){

    jQuery('.tab-content:nth-child(2)').addClass('firstelement');
    
    jQuery('#wcp-loader').hide();
    jQuery('#wcp-saved').hide();
    var sCounter = jQuery('#accordion div:last-child').find('button.fullshortcode').attr('id');
    var icons = {
        header: "dashicons dashicons-arrow-right-alt2",
        activeHeader: "dashicons dashicons-arrow-down-alt2"
    };    

    jQuery( "#accordion" ).accordion({
      collapsible: true,
      icons: icons,
      // header: '.ui-accordion-header-icon'
    });   

    
    jQuery('#about-me').on('click', '.save-pages', function(event) {
        event.preventDefault();
        jQuery('#wcp-saved').hide();
        jQuery('#wcp-loader').show();

        var allPages = [];

        jQuery('#accordion > div').each(function(index) {
            var abpage = {};

            abpage.abname = jQuery(this).find('.abname').val();
            abpage.abpicture = jQuery(this).find('.abpicture').val();
            abpage.abdesc = jQuery(this).find('.abdesc').val();
            abpage.abservice = jQuery(this).find('.abservice').val();
            abpage.abskill = jQuery(this).find('.abskill').val();
            abpage.abservices = jQuery(this).find('.abservices').val();
            abpage.abskills = jQuery(this).find('.abskills').val();
            abpage.abskin = jQuery(this).find('.abskin').val();
            
            abpage.counter = jQuery(this).find('.fullshortcode').attr('id');

            allPages.push(abpage);

        });

        // console.log(allbooks);
        var data = {
            action: 'wcp_save_all_pages',
            pages: allPages,
        }

        jQuery.post(wcpAjax.url, data, function(resp) {
            jQuery('#wcp-loader').hide();
            jQuery('#wcp-saved').show();
        });

    });
  

    jQuery('#accordion .btnadd').click(function(event) {
        event.preventDefault();
        sCounter++;
        jQuery( "#accordion" ).append('<h3>About Me</h3>');
        // jQuery(this).closest('.ui-accordion-content').clone(true).removeClass('firstelement').appendTo('#accordion').find('.shortcode').text(sCounter).closest('.tab-content').find('.wp-picker-container').remove().
        var parent_newly = jQuery(this).closest('.ui-accordion-content').clone(true).removeClass('firstelement').appendTo('#accordion').find('button.fullshortcode').attr('id', sCounter).closest('.tab-content');
        jQuery("#accordion").accordion('refresh');
    });
    jQuery('#accordion .btndelete').click(function(event) {
        event.preventDefault();
        if (jQuery(this).closest('.ui-accordion-content').hasClass('firstelement')) {
            alert('You can not delete it as it is first element!');
        } else {
            var head = jQuery(this).closest('.ui-accordion-content').prev();
            var body = jQuery(this).closest('.ui-accordion-content');
            head.remove();
            body.remove();
            jQuery("#accordion").accordion('refresh');
        }
    });

    jQuery('button.fullshortcode').click(function(event) {
        event.preventDefault();
        prompt("Copy and use this Shortcode", '[about-me id="'+jQuery(this).attr('id')+'"]');
    });

    // Media Uploader
    var about_me_page;
     
    jQuery('.upload_image_button').live('click', function( event ){
     
        event.preventDefault();
     
        var paret = jQuery(this).closest('.tab-content');
        // Create the media frame.
        about_me_page = wp.media.frames.about_me_page = wp.media({
          title: 'Select Image For About Me Page',
          button: {
            text: 'Use it!',
          },
          multiple: false  // Set to true to allow multiple files to be selected
        });
     
        // When an image is selected, run a callback.
        about_me_page.on( 'select', function() {
          // We set multiple to false so only get one image from the uploader
          attachment = about_me_page.state().get('selection').first().toJSON();
            
             paret.find('.abpicture').val(attachment.url);
        });
     
        // Finally, open the modal
        about_me_page.open();
    });    
});    