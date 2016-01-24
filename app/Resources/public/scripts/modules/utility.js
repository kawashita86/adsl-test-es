

define(function (require, exports) {
    'use strict';
    var Raphael = require('raphael');
    var $ = require('jquery');
    var ipInfoUrl = 'http://ipinfo.io';

    exports.bandwidthCircle = function bandwidthCircle(id, color) {
        var mainRadius = 80,circleRadius = 220;
        var circle = Raphael(id, circleRadius, circleRadius);
        circle.setViewBox(0, 0, circleRadius, circleRadius, true);
        var shape = circle.circle(circleRadius / 2, circleRadius / 2, mainRadius).attr({stroke: color, 'stroke-width': 10});
        shape.glow({width: 7, opacity: 0.8, color: color});
    };

    exports.getIspInformation = function getIspInformation() {
        var ispinfo;

        if ((ispinfo = this.getFromStorage('ispInfo')) !== false && typeof ispinfo.loc !== 'undefined') {
            return ispinfo;
        } else {
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
    };


    exports.getFromStorage = function getFromStorage(name) {
            try {
                return localStorage.getItem(name);
            } catch (e) {
                return false;
            }
    };

});
