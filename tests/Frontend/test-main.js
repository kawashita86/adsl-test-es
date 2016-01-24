'use strict';
var allTestFiles = [];
var TEST_REGEXP = /(spec|test)\.js$/i;

var pathToModule = function(path) {
    return path.replace(/^\/base\//, '../').replace(/\.js$/, '');
};

Object.keys(window.__karma__.files).forEach(function(file) {
    if (TEST_REGEXP.test(file)) {
        // Normalize paths to RequireJS module names.
        allTestFiles.push(pathToModule(file));
    }
});

require.config({
    baseUrl: '/base/bower_components',
    paths: {
        main: '../app/Resources/public/scripts/main',
        app: '../app/Resources/public/scripts/app',
        modules: '../app/Resources/public/scripts/modules',
        jquery: 'jquery/dist/jquery',
        loglevel: 'loglevel/dist/loglevel.min',
        bootstrap: 'bootstrap-sass-official/assets/javascripts/bootstrap',
        'bootstrap/affix': 'bootstrap-sass-official/assets/javascripts/bootstrap/affix',
        'bootstrap/alert': 'bootstrap-sass-official/assets/javascripts/bootstrap/alert',
        'bootstrap/button': 'bootstrap-sass-official/assets/javascripts/bootstrap/button',
        'bootstrap/carousel': 'bootstrap-sass-official/assets/javascripts/bootstrap/carousel',
        'bootstrap/collapse': 'bootstrap-sass-official/assets/javascripts/bootstrap/collapse',
        'bootstrap/dropdown': 'bootstrap-sass-official/assets/javascripts/bootstrap/dropdown',
        'bootstrap/modal': 'bootstrap-sass-official/assets/javascripts/bootstrap/modal',
        'bootstrap/popover': 'bootstrap-sass-official/assets/javascripts/bootstrap/popover',
        'bootstrap/scrollspy': 'bootstrap-sass-official/assets/javascripts/bootstrap/scrollspy',
        'bootstrap/tab': 'bootstrap-sass-official/assets/javascripts/bootstrap/tab',
        'bootstrap/tooltip': 'bootstrap-sass-official/assets/javascripts/bootstrap/tooltip',
        'bootstrap/transition': 'bootstrap-sass-official/assets/javascripts/bootstrap/transition',
        'appcache-nanny': 'appcache-nanny/appcache-nanny',
        picturefill: 'picturefill/dist/picturefill',
        'visionmedia-debug': 'visionmedia-debug/dist/debug',
        raphael: 'raphael/raphael',
        typeahead: 'typeahead.js/dist/typeahead.bundle',
        bloodhound: 'typeahead.js/dist/bloodhound',
        'bootstrap-validator': 'bootstrap-validator/dist/validator.min',
        'remarkable-bootstrap-notify': 'remarkable-bootstrap-notify/bootstrap-notify',
        'bootstrap-star-rating': 'bootstrap-star-rating/js/star-rating.min'
    },
    shim: {
        bootstrap: {
            exports: '$',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/affix': {
            exports: '$.fn.affix',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/alert': {
            exports: '$.fn.alert',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/button': {
            exports: '$.fn.button',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/carousel': {
            exports: '$.fn.carousel',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/collapse': {
            exports: '$.fn.collapse',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/dropdown': {
            exports: '$.fn.dropdown',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/modal': {
            exports: '$.fn.modal',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/popover': {
            exports: '$.fn.popover',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/scrollspy': {
            exports: '$.fn.scrollspy',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/tab': {
            exports: '$.fn.tab',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/tooltip': {
            exports: '$.fn.tooltip',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/transition': {
            exports: '$.fn.transition',
            deps: [
                'jquery'
            ]
        },
        typeahead: {
            deps: [
                'jquery'
            ],
            init: function ($) {
    return require.s.contexts._.registry['typeahead.js'].factory( $ );
}
        }
    },
    packages: [

    ]
});

require(allTestFiles,window.__karma__.start);
