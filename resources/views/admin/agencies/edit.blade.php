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
            @include('admin.agencies.agency-tab', [ 'agency' => $agency, 'agency_table' => $agency_config['table'] ])
        </div>
        <div class="tab-pane" id="fin-info">
            @if (Access::checkView($agency_config['table'] . '-show-fin-form'))
                @livewire('fin-component', ['agency' => $agency_config, 'agency_id' => $agency->id])     
            @endif
        </div>
    </div>
</div>
  