
(function( $, window, document, undefined ){

// Setup namespace
window.WPImageFormField = window.WPImageFormField || {};



/**
 * Open Media Library
 *
 * The event to open the thickbox with the media library.
 */
WPImageFormField.openMediaLibrary = function( event ){
	
	var $this = $( event.target );
	
	WPImageFormField.activeField = $this.parents('.wp-image-form-field');
	
};


/**
 * Remove the image
 */
WPImageFormField.removeImage = function(imageField){
  var input = imageField.find( 'input' );
  
  // Event
  var data = {
    'id': input.val(),
    'name': input.attr('name')
	};
      
  var additional = imageField.data('additional');
  if(additional) {
    data.additional = additional;
  }
	
  var event = jQuery.Event('removeImage.wpimageformfield');
  jQuery(imageField).trigger(event, [data]);
  
  if(!event.isPropagationStopped() && !event.isDefaultPrevented()) {
    
    input.val('');
    imageField.removeClass( 'wp-image-form-field-with-image' ).addClass( 'wp-image-form-field-without-image' );
    imageField.find('.wp-image-form-field--image').empty();
	}
}

/**
 * Event for the button
 */
WPImageFormField.removeImageButton = function(event) {
	var $this = $(this);
	var imageField = $this.parents('.wp-image-form-field').eq(0);
	WPImageFormField.removeImage(imageField);
	
	event.stopPropagation();
	return false;
}


// bind the links to open
$( 'a.wp-image-form-field--open-media-library' ).live( 'click', WPImageFormField.openMediaLibrary );
$( 'a.wp-image-form-field--delete' ).live( 'click', WPImageFormField.removeImageButton );



/**
 * Over-ride Thickbox tb_remove
 *
 * Over-ride it to clear the widgetInstanceId variable
 */
var old_tb_remove = window.tb_remove;
window.tb_remove = function(){
	
	// clear the WPImageFormField.widgetInstanceId value in a real short bit in case someone uses it.
	setTimeout( function(){
		WPImageFormField.widgetInstanceId = null;
		WPImageFormField.widgetInstanceCurrentField = null;
	}, 20 );
	
	// call the original tb_remove
	old_tb_remove();
};


/**
 * Over-ride send_to_editor
 */
var old_send_to_editor = window.send_to_editor;
window.send_to_editor = function(h) {
	if( !WPImageFormField.activeField || !WPImageFormField.returnedImage){
		if( old_send_to_editor ){
			return old_send_to_editor( h );
		}
		return;
	} else {
    var img = WPImageFormField.returnedImage;
    var imageField = WPImageFormField.activeField;
    
    delete(WPImageFormField.returnedImage);
    delete(WPImageFormField.activeField);
    
    var input = imageField.find('input');
    
    // send out the event
    var data = {
        'id': img.id,
        'name': input.attr('name'),
        'data': img
      };
      
    var additional = imageField.data('additional');
    if(additional) {
      data.additional = additional;
    }
    
    var event = jQuery.Event('addImage.wpimageformfield');
    jQuery(imageField).trigger(event, [data]);
    
    if(!event.isPropagationStopped() && !event.isDefaultPrevented()) {

      input.val(img.id);
      
      imageField.find('.wp-image-form-field--image').html( img.thumbnail );
      imageField.addClass( 'wp-image-form-field-with-image' ).removeClass( 'wp-image-form-field-without-image' );
      
      // Update the change link to open up this image
      var changeLink = imageField.find( 'a.wp-image-form-field--change' ); 
      var changeLinkHref = changeLink.attr('href');
      changeLinkHref = changeLinkHref.replace( /image_id=\d*/, 'image_id='+img.id );
      changeLink.attr( 'href', changeLinkHref );
    }
    
		// close thickbox
		tb_remove();
		
		return;
	}
};





/**
 * Save the returned media when media is being sent to the "editor"
 */
WPImageFormField.returnMedia = function( html, id, alt, caption, title, align, url, size, thumbnail, information ){
	WPImageFormField.returnedImage = {
		html: html, 
		id: id, 
		alt: alt, 
		caption: caption, 
		title: title, 
		align: align, 
		url: url, 
		size: size,
		thumbnail: thumbnail,
		information: information
	};
}

/**
 * Mark that the image was deleted.
 */
WPImageFormField.imageDeleted = function() {
  if(WPImageFormField.isCurrentImageDeleted) {
    WPImageFormField.removeImage(WPImageFormField.activeField);
  }
  WPImageFormField.isCurrentImageDeleted = false;
};

/**
 * Mark that the image was deleted.
 */
WPImageFormField.currentImageDeleted = function() {
  WPImageFormField.isCurrentImageDeleted = true;
};

/**
 * Fix the POST forms in the media popup to include the parameters we are carrying around in the query string
 */
WPImageFormField.fixFormActions = function(args) {
  var params = '';
  for(var key in args) {
    params = params + key + '=' + args[key] + '&amp;';
  }
  jQuery('form').each(function(){
    var t = $(this);
    var action = t.attr('action')+'';
    
    if(action=='') {
      action = window.location+''; 
    }
    
    if(action.indexOf('?') == -1) {
      t.attr('action', action+'?'+params);
    } else {
      t.attr('action', action+'&amp;'+params);
    }
    for(var key in args) {
      t.append('<input type="hidden" value="'+args[key]+'" name="'+key+'">'); 
    }
  });
}


})( jQuery, window, window.document );