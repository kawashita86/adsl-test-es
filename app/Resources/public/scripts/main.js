require(['app'], function (app) {
    'use strict';
    app.init();
    app.initLazyLoad();
    app.initJqueryInteraction();
    app.typeahead();
    app.validator();
});
