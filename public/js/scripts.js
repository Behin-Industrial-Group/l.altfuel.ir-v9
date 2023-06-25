function show_error(er){
    if(er.status == 403){
        toastr.error("دسترسی ندارید")
    }
    if(er.responseJSON){
        toastr.error(er.responseJSON.message)
    }else{
        toastr.error("خطا");
        console.log(er);
    }
    hide_loading();
}

function show_message(msg = "انجام شد" ){
    toastr.success(msg);
}