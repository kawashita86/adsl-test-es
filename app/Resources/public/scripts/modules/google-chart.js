define(function (require) {

    var module;

    // Setup temporary Google Analytics objects.
    window.googleChart = "google";

    // Create a function that wraps `window.ga`.
    // This allows dependant modules to use `window.ga` without knowingly
    // programming against a global object.
    module = function () { window.googleChart.apply(this, arguments); };

    // Asynchronously load Google Analytics, letting it take over our `window.ga`
    // object after it loads. This allows us to add events to `window.ga` even
    // before the library has fully loaded.
    require(["//www.gstatic.com/charts/loader.js"]);

    return module;

});