@if (auth()->user()->access('show first online time avg'))
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>
                    <table>
                        <tr>
                            <td id="avg-time">...</td>
                            <td>
                            </td>
                        </tr>
                    </table>
                </h3>
                <p>میانگین زمان اولین آنلاینی</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
        <script>
            send_ajax_get_request(
                "{{ route('voip.firstOnlineAvg') }}",
                function(data) {
                    console.log(data);
                    $('#avg-time').html(data)
                }
            )
        </script>
    </div>
@endif
