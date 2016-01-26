define(function (require, exports) {
    'use strict';
    var Raphael = require('raphael');
    require('morris');
    var $ = require('jquery');
    var ipInfoUrl = 'http://ipinfo.io';
    require('jquery-validation');
    var baseUrl = window.baseUrl || "";

    exports.bandwidthCircle = function bandwidthCircle(id, color) {
        var mainRadius = 80, circleRadius = 220;
        var circle = Raphael(id, circleRadius, circleRadius);
        circle.setViewBox(0, 0, circleRadius, circleRadius, true);
        var shape = circle.circle(circleRadius / 2, circleRadius / 2, mainRadius).attr({
            stroke: color,
            'stroke-width': 10
        });
        shape.glow({width: 7, opacity: 0.8, color: color});
    };

    exports.getIspInformation = function getIspInformation() {
            $.when($.getJSON(ipInfoUrl, function (data) {
                return {
                    ip: data.ip,
                    city: data.city,
                    country: data.country,
                    loc: data.loc,
                    postal: data.postal
                };
            })).then(function (data) {
                if (data.length !== 0) {
                    localStorage.setItem('ispInfo', data);
                    return data;
                }
            });
        }


    exports.getFromStorage = function getFromStorage(name) {
        try {
            return localStorage.getItem(name);
        } catch (e) {
            return false;
        }
    };

    exports.getCoverageOffers = function getCoverageOffers() {
        $.ajax({
            url: 'ajax/get-coverage-offers',
            type: 'POST',
            data: $('form#verifica-copertura').serialize(),
            dataType: 'JSON',
            success: function(data){
                if(!data.errors){
                    $('#coverage-results-container').fadeOut('slow', function(){
                        $('#cover-result-title').text('Ecco i risultati del tuo test').addClass('orange bold').css('font-size', '28px');

                        //load the content offers
                        $('#coverage-offers').html(data.template);
                        //update the data and do a fadout/fadeit
                        $('.progress-bar.progress-bar-success').text(data.distance+'m');
                        if(data.lineQuality.color == "green")
                            $('#input-20c').val('5');
                        else if(data.lineQuality.color == "yellow")
                            $('#input-20c').val('2.5');
                        else if(data.lineQuality.color == "red")
                            $('#input-20c').val('0');
                        $(this).fadeIn('slow', function(){
                            $('html, body').animate({
                                scrollTop: $('#coverage-offers').offset().top - 160
                            }, 1000);
                        });
                    });

                } else {
                    console.log(data);
                }
            },
            errors: function(){
                console.log(errors);
            }
        });
    };

    exports.validateCoperturaForm = function validateCoperturaForm() {
        $('#verifica-copertura').validate({
            rules: {
                prefisso: {
                    digits: true,
                    minlength: 3,
                    maxlength: 3
                },
                cellulare: {
                    digits: true,
                    minlength: 6,
                    maxlength: 7
                },
                telefono: {
                    digits: true
                },
                email: {
                    required: true
                },
                comune: {
                    required: true
                },
                indirizzo: {
                    required: true
                }
            },
            messages: {
                prefisso: {
                    digits: "Inserire un prefisso valido",
                    minlength: "Inserire un prefisso valido",
                    maxlength: "Inserire un prefisso valido"
                },
                cellulare: {
                    digits: "Inserire un numero di cellulare valido",
                    minlength: "Inserire un numero di cellulare valido",
                    maxlength: "Inserire un numero di cellulare valido"
                },
                telefono: {
                    digits: "Inserire un numero di telefono valido",
                    minlength: "Inserire un numero di telefono valido",
                    maxlength: "Inserire un numero di telefono valido"
                },
                email: "Inserire un indirizzo email",
                privacy: "Accettare l'informativa sulla privacy",
                comune: "Inserire il comune",
                indirizzo: "Inserire l'indirizzo"
            },
            errorPlacement: function (error) {
                $.notify({message: error.text()}, {placement: { from: 'bottom' }, type: 'danger'});
            },
            submitHandler: function (form) {
                // do other things for a valid form
                //do the speed test, or call the coverage offers, based on the element passed
                return false;

            }

        });
    }

    exports.generateChartAvgHourly = function generateChartAvgHourly(){
            $.get('ajax/get-avg-hourly',function(data){
                if (data.length > 2){
                    $('.graph-container').fadeIn('slow',function(){
                        Morris.Line({
                            element: 'graph-trends',
                            lineColors: ['#5cb85c','#EF4836'],
                            parseTime: false,
                            data: data,
                            units: 'Mbit/s',
                            xkey: 'dtf',
                            ykeys: ['download','upload'],
                            labels: ['Download','Upload']
                        });
                    });

                }
            },'json');
    }

});
