@if (config('pm_config.debug'))
    <div class="col-sm-12" dir="ltr">
        <pre>
            {{ print_r($vars) }}
        </pre>
    </div>
@endif

@yield('content')
