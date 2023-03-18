function send_ajax_request(url, data, callback, erCallback = null){
    show_loading()
    if(erCallback == null){
        erCallback= function(data){ 
            hide_loading();
            error_notification('<p dir="ltr">' + JSON.stringify(data) + '</p>');
        }
    }
    return $.ajax({
        url: url,
        data: data,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'post',
        success: function(){
            hide_loading();
        },
        error: erCallback
    })
    .done(callback)
    .catch(erCallback);
}

function send_ajax_get_request(url, callback, erCallback = null){
    show_loading()
    if(erCallback == null){
        erCallback= function(data){ 
            hide_loading();
            error_notification('<p dir="ltr">' + JSON.stringify(data) + '</p>');
        }
    }
    return $.ajax({
        url: url,
        processData: false,
        async: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'get',
        success: function(){
            hide_loading();
        },
        error: erCallback
    })
    .done(callback);
}

function send_ajax_get_request_with_confirm(url, callback, message = "Are you sure?", erCallback = null){
    if (confirm(message) == true) {
        show_loading()
        if(erCallback == null){
            erCallback= function(data){ 
                hide_loading();
                error_notification('<p dir="ltr">' + JSON.stringify(data) + '</p>');
            }
        }
        return $.ajax({
                url: url,
                processData: false,
                async: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'get',
                success: function(){
                    hide_loading();
                },
                error: erCallback
            })
            .done(callback);
    } else {
        return false;
    }
}

function show_loading(){
    $('#preloader').show();
}

function hide_loading(){
    $('#preloader').hide();
}

function open_admin_modal(url){
    send_ajax_get_request(
        url,
        function(data){
            $('#modal #modal-body').html(data);
            $('#modal').modal('show')
        }
    )
}


