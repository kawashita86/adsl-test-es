'use strict';
module.exports =  {
    all: [
        '<%= paths.app %>/scripts/**/*.js',
        // don't lint as this is autogenerated
        '!<%= paths.app %>/scripts/config.js'
    ]
};
