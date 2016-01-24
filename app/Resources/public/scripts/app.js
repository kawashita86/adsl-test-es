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
  //  var serviceWorker = require('./modules/service-worker');
    var debug = require('visionmedia-debug')('adslTestEs:main');
    var raphael = require('raphael');
    var speedtest = require('./modules/speed-test');
    var utility = require('./modules/utility');
    var typeahead = require('typeahead');
 //   var googleChart = require('./modules/google-chart');
    require('bloodhound');
    require('bootstrap');

    exports.init = function init() {
        debug('\'Allo \'Allo');
        debug('Running jQuery:', $().jquery);
        debug('Running Bootstrap:', Boolean($.fn.scrollspy) ? '~3.3.0' : false);

    //    serviceWorker.init();


        window.google.charts.load('current', {packages: ['gauge']});
        window.google.charts.setOnLoadCallback(drawChart);
    };

    exports.initJqueryInteraction = function initJqueryInteraction() {
        $('a[href="#verifica-copertura"]').click(function () {
            $('html, body').animate({
                scrollTop: $('#verifica-copertura').offset().top
            }, 2000);
        });

        $('#speed-test-modal').on('shown.bs.modal', function () {
            console.log('start speedtest');
            speedtest.startSpeedTest();
        });

       if($('#download').length !== 0)
            utility.bandwidthCircle('download', '#5cb85c');
        if($('#upload').length !== 0)
            utility.bandwidthCircle('upload', '#d9534f');
    };

    exports.typeahead = function typeahead() {
        var findCity = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '/ajax/find/city?city=%QUERY',
                wildcard: '%QUERY'
            }
        });

        var findStreet = new Bloodhound({
            datumTokenizer: function (datum) {
                Bloodhound.tokenizers.obj.whitespace(datum.toponomastica);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '/ajax/find/street?street=',
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
                url: '/ajax/find/civic?civic=',
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

        $('#indirizzo').typeahead(null, {
            name: 'find-indirizzo',
            display: 'value',
            source: findStreet,
            templates: {
                empty : [
                    '<div class="empty-message">',
                    'Nessun indirizzo trovato',
                    '</div>'
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
            localStorage.setItem('civic', datum);
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
