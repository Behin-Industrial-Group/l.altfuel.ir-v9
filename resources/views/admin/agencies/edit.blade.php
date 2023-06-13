@php
   use App\CustomClasses\Access;
@endphp
<div class="card card-info">
    <div class="card-header">
        <ul class="nav nav-tabs">
            <li class="nav-item active"><a href="#info" class="nav-link active" data-toggle="tab">مشخصات صنفی</a></li>
            <li class="nav-item "><a href="#fin-info" class="nav-link " data-toggle="tab">اطلاعات مالی</a></li>
        </ul>
    </div>
    
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
  