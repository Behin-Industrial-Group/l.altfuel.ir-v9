<?php 
use App\CustomClasses\Access;
?>

<div class="modal fade" id="modal-fin-edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">
              ویرایش اطلاعات  
              مرکز: <span id="markaz-fullname"></span>
              کد: <span id="markaz-code"></span>
            </h4>
        </div>
        <div class="modal-body">
            <input type="hidden" name="markaz_id" id="">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#info" data-toggle="tab">مشخصات صنفی</a></li>
                  <li><a href="#fin-info" data-toggle="tab">اطلاعات مالی</a></li>
                </ul>
                <div class="tab-content">
                  <div class="active tab-pane" id="info">
                        @include('admin.hidro.markaz-edit-form')
                  </div>
                  <div class="tab-pane" id="fin-info">
                        @include('admin.hidro.fin-edit-form')
                  </div>
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">خروج</button>
        </div>
      </div>
    </div>
</div>
