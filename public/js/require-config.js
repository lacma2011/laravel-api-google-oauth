var requireJS = (function(requireJS_AMD){



var config = {

    // Sets the js folder as the base directory for all future relative paths
    baseUrl: 'js',

    urlArgs: "pvApi=v1"
    // add time to  end of urlArgs during development for more immediate cache breaking:
          + "&time=" + (new Date()).getTime(),

    // 3rd party script alias names (Easier to type "jquery" than "libs/jquery, etc")
    paths: {
        'jquery': "vendor/jquery/jquery-3.1.1.min",
        'backbone' : 'vendor/backbone/backbone-min',
        'underscore' : 'vendor/underscore/underscore-min',
        'google-api-client' : 'vendor/google/api/api',
        'template-loader' : 'template-loader',
        'app' : 'app',
        
        // backbone modules
        'bb-artist-model' : 'bb/ArtistModel',
        'bb-artist-collection': 'bb/ArtistCollection',
        'bb-artist-view': 'bb/ArtistView',
        'bb-artists-view' : 'bb/ArtistsView'
    },

    shim: {
        'app': {
            deps: ['jquery']
        },
        'backbone' : {
            deps: ['underscore']
        },
        'bb-artist-model' : {
            deps: ['backbone']
        },
        'bb-artist-collection' : {
            deps: ['bb-artist-model', 'backbone']
        },
        'bb-artist-view' : {
            deps: ['backbone']
        },
        'bb-artists-view' : {
            deps: ['bb-artist-view', 'backbone']
        }
    },

    map: {
      // '*' means all modules will get 'jquery-noconflict'
      // for their 'jquery' dependency.
      '*': {
          'jquery': 'jquery-noconflict'
      },

      // 'jquery' wants the real jQuery module
      // though. If this line was not here, there would
      // be an unresolvable cyclic dependency.
      'jquery-noconflict': { 'jquery': 'jquery' }
    }
};

return requireJS_AMD.config(config);



}(require));
