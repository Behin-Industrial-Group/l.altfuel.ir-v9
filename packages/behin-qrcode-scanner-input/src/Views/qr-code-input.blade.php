<style>
    .result {
        background-color: green;
        color: #fff;
        padding: 20px;
    }

    .row {
        display: flex;
    }
</style>

<div class="">
    <div class="col-sm-12 p-0">
        <div style="width:100%;" id="reader"></div>
    </div>
    <div class="col-sm-12 p-0" style="padding:30px;">
        {{-- <h4>SCAN RESULT</h4> --}}
        {{-- <div id="result">Result Here</div> --}}
        {{-- <button class="btn btn-primary" id="startScan">اسکن</button> --}}
        <input type="text" name="qr_code" id="qr_code" class="form-control" readonly>
    </div>
    
</div>

<script src="{{ url('packages/behin-qrcode-scanner-input/src/public/js/html5-qrcode.min.js') }}"></script>
<script type="text/javascript">
    function domReady(fn) {
        if (document.readyState === "complete" || document.readyState === "interactive") {
            setTimeout(fn, 1);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    domReady(function() {
        var myqr = document.getElementById("result");
        var qr_code = document.getElementById("qr_code");
        var lastResult, countResults = 0;
        var html5QrcodeScanner; // متغیر برای اسکنر

        function onScanSuccess(decodeText, decodeResult) {
            var audio = new Audio('{{ url('public/beep.mp3') }}');
            audio.play();
            

            // if (decodeText !== lastResult) {
            //     ++countResults;
            //     lastResult = decodeText;

                // Update the result element with the scanned QR code text
                // myqr.innerHTML = `You scanned ${countResults} : ${decodeText}`;
                qr_code.value = decodeText;
            // }
        }

        function onScanError(errorMessage) {
            // Optionally handle scan errors here
            // console.error(errorMessage);
        }

        // ایجاد رویداد کلیک برای شروع اسکن
        // document.getElementById('startScan').addEventListener('click', function() {
        //     // ایجاد نمونه اسکنر و رندر منطقه اسکن
        //     html5QrcodeScanner = new Html5QrcodeScanner(
        //         "reader", {
        //             fps: 10,
        //             qrbox: 250
        //         }
        //     );
        //     html5QrcodeScanner.render(onScanSuccess, onScanError);
        // });

        html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 10,
                    qrbox: 250
                }
            );
            html5QrcodeScanner.render(onScanSuccess, onScanError);
    });
</script>
