define(function (require, exports) {
    'use strict';
    var $ = require('jquery');
    var utility = require('./utility');
    require('bootstrap');
    require('remarkable-bootstrap-notify');
    var baseUrl = window.baseUrl || "";

    exports.startSpeedTest = function startSpeedTest(isCoverage) {
        window.sc_skin = '';
        window.sc_bgc = '0x123456';
        window.sc_bc = '0x000000';
        window.sc_hc = '0xA8D01E';
        window.sc_cc = '0xFF950D';
        window.sc_w = 400;
        window.sc_h = 250;
        window.sc_userid = 42887263;
        window.sc_location = 'IT';
        window.version = 3;
        var sc_script = document.createElement('script');
        sc_script.setAttribute('src', (((document.location.protocol === 'https:') ? 'https' : 'http') + '://www.speedcheckercdn.com/speedchecker.js'));
        document.getElementsByTagName('head')[0].appendChild(sc_script);

        var MessageSpeedTest = function (e) {
            if (e.data.type === 'speedcheckerTakenTestSaved' && typeof e.data.value !== 'undefined' && undefined !== e.data.value.TakenTestId) {
                saveTestResult(e.data.value, isCoverage);
            }
        };
        setTimeout(function () {
            window.addEventListener('message', MessageSpeedTest, false);
        }, 1500);
    };

    function saveTestResult(obj, isCoverage) {
        var dataSend = {};
        dataSend.provider = (obj.Provider.Title) ? obj.Provider.Title : '';
        dataSend.downloadSpeed = (obj.TakenTest.Download.speedInKbps) ? obj.TakenTest.Download.speedInKbps : '';
        dataSend.uploadSpeed = (obj.TakenTest.Upload.speedInKbps) ? obj.TakenTest.Upload.speedInKbps : '';
        dataSend.ipAddress = (obj.TakenTest.User.Location.IPAddress) ? obj.TakenTest.User.Location.IPAddress : '';
        dataSend.ping = (obj.TakenTest.Ping.time) ? obj.TakenTest.Ping.time : '';
        dataSend.takenTestId = (obj.TakenTestId) ? obj.TakenTestId : '';
        dataSend.city = utility.getFromStorage('city');
        var ispInfo = utility.getIspInformation();
        if (typeof ispInfo !== 'undefined' && ispInfo !== false && typeof ispInfo.loc !== 'undefined') {
            var location = ispInfo.loc.split(',');
            dataSend.latitude = location[0];
            dataSend.longitude = location[1];
        } else {
            dataSend.latitude = "";
            dataSend.longitude = "";
        }
        $.ajax({
            url:  "ajax/save-result",
            type: 'POST',
            data: dataSend,
            dataType: 'json',
            success: function (data) {
                if (typeof data.id !== 'undefined') {
                    //location.navigator += "/adsl-result/" + data.id;
                    if (!isCoverage)
                        setResults(dataSend);
                    else
                        loadResults(dataSend);
                }
                else
                    $.notify({ message: 'Qualcosa è andato storto durante il test'}, {placement: { from: 'bottom' }, type: 'danger'});
            },
            error: function () {
                $.notify({message: 'aaaa'}, {type: 'danger'});
            }
        });
    }

    function loadResults(dataSend) {
        $.ajax({
            url: 'ajax/get-coverage-offers',
            type: 'POST',
            data: {},
            dataType: 'JSON',
            success: function (data) {
                if (!data.errors) {
                    $('#coverage-results-container').fadeOut('slow', function () {
                        $('#cover-result-title').text('Ecco i risultati del tuo test').addClass('orange bold').css('font-size', '28px');
                        $('#speed-test-modal').modal('toggle');
                        generateSpeedTestElement(dataSend);
                        //load the content offers
                        $('#coverage-offers').html(data.template);
                        //update the data and do a fadout/fadeit
                        $('.progress-bar.progress-bar-success').text(data.distance + 'm');
                        if (data.lineQuality.color == "green")
                            $('#input-20c').val('5');
                        else if (data.lineQuality.color == "yellow")
                            $('#input-20c').val('2.5');
                        else if (data.lineQuality.color == "red")
                            $('#input-20c').val('0');
                        $(this).fadeIn('slow', function () {
                            $('html, body').animate({
                                scrollTop: $('#coverage-offers').offset().top - 160
                            }, 1000);
                        });
                    });

                } else {
                   $.notify({ message: 'Qualcosa è andato storto durante il test'}, {placement: { from: 'bottom' }, type: 'danger'});
                }
            },
            errors: function () {
                console.log(errors);
            }
        });
    }

    function generateSpeedTestElement(dataSend){
        $('#dynamic-container').addClass('col-md-6 col-lg-6 col-sm-12 col-xs-12');
        $('#dynamic-container > div').removeClass('col-md-6 col-lg-6').addClass('col-md-12 col-lg-12');
        var clonedResult = $('#data-wrapper').clone();
        clonedResult.find('div,span,em').each(function(index) {
            if(this.id.length !== 0)
                this.id = this.id + '-coverage';
        });
        clonedResult.attr('id', clonedResult.attr('id')+'-coverage');
        $('#dynamic-container').before($(clonedResult));
        $('#speedo-status-coverage').text(dataSend.city);
        $('#speedo-ping-coverage').text(dataSend.ping);
        $('#speedo-down-coverage').text(Number(dataSend.downloadSpeed / 1000).toFixed(2));
        $('#speedo-up-coverage').text(Number(dataSend.uploadSpeed / 1000).toFixed(2));
        $('#speedo-ip-coverage').text(dataSend.ipAddress);
        $('#speedo-provider-coverage').html('<img src="/img/brands/' + dataSend.provider.toLowerCase() + '.png" />');
    }

    function setResults(dataSend) {
        $('#speed-test-modal').modal('toggle');
        $('.speed-test-sample').fadeOut('slow', function () {
            $('#speed-result-title').text('Ecco i risultati del tuo test').addClass('orange bold').css('font-size', '28px');
            $('#speedo-status').text(dataSend.city);
            $('#speedo-ping').text(dataSend.ping);
            $('#speedo-down').text(Number(dataSend.downloadSpeed / 1000).toFixed(2));
            $('#speedo-up').text(Number(dataSend.uploadSpeed / 1000).toFixed(2));
            $('#speedo-ip').text(dataSend.ipAddress);
            $('#speedo-provider').html('<img src="/img/brands/' + dataSend.provider.toLowerCase() + '.png" />');
            $(this).fadeIn('slow', function () {
                $('html, body').animate({
                    scrollTop: $('.speed-test-sample').offset().top + 10
                }, 1000);
            });
        });
    }

});
