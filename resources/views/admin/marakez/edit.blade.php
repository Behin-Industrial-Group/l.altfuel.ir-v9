@php
    use App\CustomClasses\Access;
@endphp
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#info" data-toggle="tab">مشخصات صنفی</a></li>
        <li><a href="#fin-info" data-toggle="tab">اطلاعات مالی</a></li>
    </ul>
    <div class="tab-content">
        <div class="active tab-pane" id="info">
            @include('admin.marakez.markaz-edit-form', [ 'agency' => $markaz ])
        </div>
        <div class="tab-pane" id="fin-info">
            @if(Access::checkView('show_fin_form'))
                @livewire('fin-component', ['agency' => config('app.agencies.high-pressure'), 'agency_id' => $markaz->id])
            @endif
        </div>
    </div>
</div>
