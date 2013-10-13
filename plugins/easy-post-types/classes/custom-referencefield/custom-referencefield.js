if (typeof referenceField == 'undefined')
    var referenceField = {};
else
    referenceField = referenceField||{};


referenceField.addPost = function(params) {
    var data = {
        action: 'referencefield_add_postitem',
        postid: params['postid'],
        refid: params['refid'],
        field_name: params['field_name'],
        type: params['type'],
        text: jQuery('#texttosearch').val(),
        published: jQuery("[name='status-published']").attr('checked')=='checked'?true:false,
        draft: jQuery("[name='status-draft']").attr('checked')=='checked'?true:false
        };
    jQuery.post(params['url'], data, function(response) {
        jQuery('#reference_searchlist-'+data['field_name']).html(response);
        data['url'] = params['url'];
        referenceField.refreshPosts(data);
        alert(referenceField.__('added'));
    });
}

referenceField.removePost = function(params) {
    var data = {
        action: 'referencefield_remove_postitem',
        postid: params['postid'],
        refid: params['refid'],
        field_name: params['field_name'],
        type: params['type']
        };
    jQuery.post(params['url'], data, function(response) {
        jQuery('#reference-table-posts-'+data['field_name']).html(response);
        data['url'] = params['url'];
        referenceField.searchPost(data);
        alert(referenceField.__('removed'));
    });
}

referenceField.searchPost = function(params) {
    var data = {
        action: 'referencefield_search_posts',
        postid: params['postid'],
        field_name: params['field_name'],
        type: params['type'],
        page: params['page'],
        text: jQuery('#texttosearch').val(),
        published: jQuery("[name='status-published']").attr('checked')=='checked'?true:false,
        draft: jQuery("[name='status-draft']").attr('checked')=='checked'?true:false
        };
    jQuery.post(params['url'], data, function(response) {
        jQuery('#reference_searchlist-'+data['field_name']).html(response);
    });
}

referenceField.refreshPosts = function(params) {
    var data = params;
    data['action']='referencefield_refresh_posts';
    jQuery.post(params['url'], data, function(response) {
        jQuery('#reference-table-posts-'+data['field_name']).html(response);
    });
}

referenceField.orderPosts = function(params) {
    params['action']='referencefield_order_posts';
    jQuery.post(params['url'], params, function(response) {
    });
}
