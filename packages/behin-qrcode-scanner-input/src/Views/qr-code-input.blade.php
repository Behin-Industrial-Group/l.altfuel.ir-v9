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

<div class="row">
    <div class="col" style="padding:30px;">
        <h4>SCAN RESULT</h4>
        <div id="result">Result Here</div>
        <button id="startScan">Start Scanning</button> <!-- دکمه برای شروع اسکن -->
    </div>
    <div class="col">
        <div style="width:500px;" id="reader"></div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
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
        var lastResult, countResults = 0;
        var html5QrcodeScanner; // متغیر برای اسکنر

        function onScanSuccess(decodeText, decodeResult) {
            if (decodeText !== lastResult) {
                ++countResults;
                lastResult = decodeText;

                // Update the result element with the scanned QR code text
                myqr.innerHTML = `You scanned ${countResults} : ${decodeText}`;
            }
        }

        function onScanError(errorMessage) {
            // Optionally handle scan errors here
            console.error(errorMessage);
        }

        // ایجاد رویداد کلیک برای شروع اسکن
        document.getElementById('startScan').addEventListener('click', function() {
            // ایجاد نمونه اسکنر و رندر منطقه اسکن
            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 10,
                    qrbox: 250
                }
            );
            html5QrcodeScanner.render(onScanSuccess, onScanError);
        });
    });
</script>
