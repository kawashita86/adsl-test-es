
define(function (require, exports) {
    'use strict';
    var $ = require('jquery');

    exports.startSpeedTest = function startSpeedTest() {
        $('#sample-test-img').hide();
        window.sc_skin = '';
        window.sc_bgc = '0xFFFFFF';
        window.sc_bc = '0x20A834';
        window.sc_hc = '0x33FF36';
        window.sc_cc = '0x1E291F';
        window.sc_w = 400;
        window.sc_h =250 ;
        window.sc_userid = 42887263;
        window.sc_location = 'IT';
        window.version = 3;
        var sc_script = document.createElement('script');
        sc_script.setAttribute('src', (((document.location.protocol === 'https:') ? 'https' : 'http') + '://www.speedcheckercdn.com/speedchecker.js'));
        document.getElementsByTagName('head')[0].appendChild(sc_script);

        var MessageSpeedTest = function (e) {
            if (e.data.type === 'speedcheckerTakenTestSaved' && typeof e.data.value !== 'undefined' && undefined !== e.data.value.TakenTestId) {
                saveTestResult(e.data.value);
            }
        };
        setTimeout(function () {
            window.addEventListener('message', MessageSpeedTest, false);
        }, 1500);
    };

    function saveTestResult(obj) {
        var dataSend = {};
        dataSend.provider = (obj.Provider.Title) ? obj.Provider.Title : '';
        dataSend.downloadSpeed = (obj.TakenTest.Download.speedInKbps) ? obj.TakenTest.Download.speedInKbps : '';
        dataSend.uploadSpeed = (obj.TakenTest.Upload.speedInKbps) ? obj.TakenTest.Upload.speedInKbps : '';
        dataSend.ipAddress = (obj.TakenTest.User.Location.IPAddress) ? obj.TakenTest.User.Location.IPAddress : '';
        dataSend.ping = (obj.TakenTest.Ping.time) ? obj.TakenTest.Ping.time : '';
        dataSend.latitude = "xx";
        dataSend.longitude = "xx";
        $.ajax({
            url: "/ajax/save-result",
            type: 'POST',
            data: dataSend,
            dataType: 'json',
            success: function(data){
                if(typeof data.id !== 'undefined')
                    location.href =  "/adsl-result/" + id;
                else
                    alert('error');
            },
            error: function() {
                //  toastit("ERRORE! Test della velocità fallito!")
            }
        });
    }


});
