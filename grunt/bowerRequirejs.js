'use strict';
module.exports = {
    options: {
        exclude: ['modernizr', 'requirejs', 'almond', 'bootstrap-sass-official'],
        baseUrl: 'bower_components'
    },
    dist: {
        rjsConfig: '<%= paths.app %>/scripts/config.js'
    },
    test: {
        rjsConfig: 'tests/Frontend/test-main.js'
    }
};
