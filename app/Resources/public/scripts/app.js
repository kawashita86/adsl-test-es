/**
 *
 * @author Ben Zörb @bezoerb https://github.com/bezoerb
 * @copyright Copyright (c) 2015 Ben Zörb
 *
 * Licensed under the MIT license.
 * http://bezoerb.mit-license.org/
 * All rights reserved.
 */
define(function (require, exports) {
    'use strict';
    var $ = require('jquery');
    window.jQuery =  $;
    var raphael = require('raphael');
    var speedtest = require('./modules/speed-test');
    var utility = require('./modules/utility');
    var baseUrl = window.baseUrl || "";
    var requestCoverage = true;
    require('typeahead');
    require('bloodhound');
    require('bootstrap');
    require('remarkable-bootstrap-notify');
    require('bootstrap-star-rating');
    require('jquery.lazyload');

    exports.init = function init() {

        utility.getIspInformation();
        //check for all the variables in local storage and set them.
        if(localStorage.getItem('city')){
            $('#comune, #comune_provider').val(localStorage.getItem('city'));
            $('#indirizzo, #tipo_via').prop('disabled', false);
            if(localStorage.getItem('street')){
                $('#indirizzo').val(localStorage.getItem('street'));
                $('#civico').prop('disabled', false);
                if(localStorage.getItem('civic')){
                    $('#civico').val(localStorage.getItem('civic'));
                }

            }
        }

        if(typeof (window.google) !== 'undefined') {
            window.google.charts.load('current', {packages: ['gauge']});
            window.google.charts.setOnLoadCallback(drawChart);
        }

        utility.generateChartAvgHourly();
    };

    exports.initJqueryInteraction = function initJqueryInteraction() {
        $('a[href="#verifica-copertura"]').click(function () {
            $('html, body').animate({
                scrollTop: $('#verifica-copertura').offset().top - 150
            }, 2000);
        });

        $('#speed-test-modal').on('shown.bs.modal', function (e) {
            speedtest.startSpeedTest(requestCoverage);
        });

        $('#start_speed_test').click(function(e){
            e.preventDefault();
            if(!localStorage.getItem('city'))
                $.notify({message: 'Inserisci il tuo comune'},{placement: { from: 'bottom' },type: 'danger'  });
            else {
                var speedModal = $('#speed-test-modal').modal({backdrop: 'static', keyboard: false});
                requestCoverage = false;
                speedModal.modal('show');
            }
        });


       if($('#download').length !== 0)
            utility.bandwidthCircle('download', '#5cb85c');
        if($('#upload').length !== 0)
            utility.bandwidthCircle('upload', '#d9534f');

        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();

        $("#input-20c").rating({
            clearButton: '',
            clearElement: '',
            captionElement: '',
            symbol: "\uf111",
            glyphicon: false,
            size: 'sm',
            ratingClass: "rating-fa", // the rating class will ensure font awesome icon rendering
            defaultCaption: "{rating} cups",
            starCaptions: {}
        });
    };

    exports.initLazyLoad = function lazyLoad() {
            $("img.lazy").lazyload({
                threshold : 200
            });

    };

    exports.typeahead = function typeahead() {
        var findCity = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: 'ajax/find/city?city=%QUERY',
                wildcard: '%QUERY'
            }
        });

        var findStreet = new Bloodhound({
            datumTokenizer: function (datum) {
                Bloodhound.tokenizers.obj.whitespace(datum.toponomastica);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url:  'ajax/find/street?street=',
                replace: function (url, query) {
                    url += query;
                    if(localStorage.getItem('city'))
                        url += '&city='+encodeURIComponent(localStorage.getItem('city'));
                    return url;
                }
            }
        });

        var findCivic = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url:  'ajax/find/civic?civic=',
                replace: function (url, query) {
                    url += query;
                    if(localStorage.getItem('city'))
                        url += '&city='+encodeURIComponent(localStorage.getItem('city'));
                    if(localStorage.getItem('street'))
                        url += '&street='+encodeURIComponent(localStorage.getItem('street'));
                    if(localStorage.getItem('particella'))
                        url += '&particella='+encodeURIComponent(localStorage.getItem('particella'));
                    return url;
                }
            }
        });

        $('#comune_provider').typeahead(null, {
            name: 'find-city',
            display: 'value',
            source: findCity
        }).on('typeahead:selected', function (e, datum) {
            localStorage.setItem('city', datum.value);
            $('#comune').val(datum.value);
            $('#tipo_via').prop('disabled', false);
            $('#indirizzo').prop('disabled', false);
        });

        $('#comune').typeahead(null, {
            name: 'find-city',
            display: 'value',
            source: findCity
        }).on('typeahead:selected', function (e, datum) {
            localStorage.setItem('city', datum.value);
            $('#comune_provider').val(datum.value);
            $('#tipo_via').prop('disabled', false);
            $('#indirizzo').prop('disabled', false);
        });

        $('#indirizzo').typeahead(null, {
            name: 'find-indirizzo',
            display: 'value',
            source: findStreet,
            templates: {
                empty : [
                    '<div class="empty-message">Nessun indirizzo trovato</div>'
                ],
                suggestion: function(data){return '<span>'+ data.particella_ext+' '+ data.toponomastica+'</span>'},
                header: ''
            }
        }).on('typeahead:selected', function (e, datum) {
            localStorage.setItem('street', datum.toponomastica);
            localStorage.setItem('particella', datum.particella);
            $('#indirizzo').val(datum.toponomastica);
            $('#tipo_via').val(datum.particella_ext);
            $('#civico').prop('disabled', false);
        });

        $('#civico').typeahead(null, {
            name: 'find-civic',
            display: 'value',
            source: findCivic
        }).on('typeahead:selected', function (e, datum) {
            localStorage.setItem('civic', datum.value);
        });

    };

    exports.validator = function validator(){
            utility.validateCoperturaForm();

            $('#test-speed-coverage').click(function(e){
               e.preventDefault();
               if($('#verifica-copertura').valid()) {
                   requestCoverage = true;
                   var speedModal = $('#speed-test-modal').modal({backdrop: 'static', keyboard: false});
                   speedModal.modal('show');
               }
            });

        $('#get-coverage').click(function(e){
            e.preventDefault();
            if($('#verifica-copertura').valid())
                utility.getCoverageOffers();
        });
    };

    function drawChart(){
        $(".chart-gauge").each(function() {
            var speed = $(this).data("speed"), label = $(this).data("label");
            var maxValue, greenMinVal, greenMaxVal, minorTicks;
            var e = google.visualization.arrayToDataTable([
                ["Label", "Value"],
                [label, speed]
            ]);
            "Upload" == label ? (maxValue = 10, greenMinVal = 7, greenMaxVal = 10, minorTicks = 1) : (maxValue = 100, greenMinVal = 70, greenMaxVal = 100, minorTicks = 5);
            var t = {
                height: 90,
                max: maxValue,
                greenFrom: greenMinVal,
                greenTo: greenMaxVal,
                minorTicks: minorTicks
            };
            var chartID = $(this).attr("id");
            var i = new window.google.visualization.Gauge(document.getElementById(chartID));
            i.draw(e, t)
        })
    }

});
