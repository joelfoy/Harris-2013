jQuery(function(){


/**
 * This opens the current image that is selected. 
 * 
 */
var id = location.search;
var re = /^(.*&)?image_id=(\d+)/;
var m = re.exec(id);

if( m ){
  var imgId = m[2];
  
  setTimeout( function(){
    var mi = jQuery( '#media-item-'+imgId );
    mi.find( 'a.describe-toggle-on' ).click();
    mi.find('div.del-attachment a[href!="#"]').click(function(event){
      var win = window.dialogArguments || opener || parent || top;
			win.WPImageFormField = win.WPImageFormField || {};
			if(win.WPImageFormField.currentImageDeleted){
			  win.WPImageFormField.currentImageDeleted();
			}
    });
  }, 10 );
}



});