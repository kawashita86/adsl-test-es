

define(function (require, exports) {
    'use strict';
    var Raphael = require('raphael');

    exports.bandwidthCircle = function bandwidthCircle(id, color) {
        var mainRadius = 80,circleRadius = 220;
        var circle = Raphael(id, circleRadius, circleRadius);
        circle.setViewBox(0, 0, circleRadius, circleRadius, true);
        var shape = circle.circle(circleRadius / 2, circleRadius / 2, mainRadius).attr({stroke: color, 'stroke-width': 10});
        shape.glow({width: 7, opacity: 0.8, color: color});
    };

});
