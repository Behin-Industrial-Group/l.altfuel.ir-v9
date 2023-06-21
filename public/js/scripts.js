function show_error(er){
    if(er.status == 403){
        toastr.error("دسترسی ندارید")
    }else{
        toastr.error("خطا");
        toastr.error(JSON.stringify(er))
    }
    hide_loading();
}

function show_message(msg = "انجام شد" ){
    toastr.success(msg);
}