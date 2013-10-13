if (typeof imageField == 'undefined')
    var imageField = {};
else
    imageField = imageField||{};

imageField.removeImage = function(params) {
    var data = {
        action: 'imgfield_remove_image',
        index: params['index'],
        postid: params['postid'],
        field_name: params['image']
        };
    jQuery.post(params['url'], data, function(response) {
        jQuery('#image-listing_'+params['image']).html(response);
        alert(imageField.__('deleted'));
    });
}

/*imageField.addImage = function(params) {
    var imageVal=jQuery("input[name='"+params['image']+"']").val();
    if (imageVal.length==0) {
        alert(imageField.__('nfile'));
        return;
    }
    var data = {
        action: 'imgfield_add_image',
        field_name: params['image'],
        image: imageVal,
        title: jQuery("input[name='"+params['title']+"']").val(),
        alt: jQuery("input[name='"+params['alt']+"']").val(),
        postid: params['postid'],
        posttype: params['posttype'],
        extra: params['extra']
        };

    jQuery.post(params['url'], data, function(response) {
        jQuery('#image-listing_'+params['image']).html(response);
        alert(imageField.__('added'));
    });
}*/

jQuery(window).ready(function(){
  jQuery('body').bind('addImage.wpimageformfield', function(event, data) {
    var field = jQuery(event.target);
    
    var form_data = {
        action: 'imgfield_add_image',
        field_name: data.name,
        imageId: data.id,
        image: data.data.information.file,
        title: data.data.title,
        alt: data.data.alt,
        postid: data.additional.postid,
        extra: data.additional.extra
        };
    
    jQuery.post(ajaxurl, form_data, function(response) {
      jQuery('#image-listing_'+data.name).html(response);
    });
    
    event.stopPropagation();
  });
  
  
  jQuery('body').bind('removeImage.wpimageformfield', function(event, data) {
    var field = jQuery(event.target);
    
    var form_data = {
        action: 'imgfield_remove_image',
        index: data.additional.index,
        field_name: data.name,
        imageId: data.id,
        postid: data.additional.postid,
        extra: data.additional.extra
        };
    
    jQuery.post(ajaxurl, form_data, function(response) {
      jQuery('#image-listing_'+data.name).html(response);
    });
    
    event.stopPropagation();
  });
});