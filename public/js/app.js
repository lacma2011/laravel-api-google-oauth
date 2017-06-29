
// AMD definition

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery', 'backbone', 'google-api-client', 'template-loader'], factory);
    } else {
        // this won't really do anything, because no global made currently...
        factory(jQuery);
    }
}(function ($, BB, gapi, templateLoader) {

    return function () {
        
        // Settings for Google OAuth client
        var GoogleAuth;
        var SCOPE = 'https://www.googleapis.com/auth/plus.me';
        var discoveryUrl = 'https://www.googleapis.com/discovery/v1/apis/plus/v1/rest';

        // Make API location
        var apiEndpoint = location.protocol+'//' + location.hostname + (location.port ? ':' + location.port: '') + '/api';

        // Going to do 3 async loads...

        var deferredBB = $.Deferred(), // #1
            deferredTemplates = $.Deferred(), // #2
            deferredGoogleAPI = $.Deferred(); // #3

        // #1 Get Backbone objects. ArtistCollection needs a runtime config (hence the closure)
        requireJS(['bb-artist-collection','bb-artists-view'],
                function(ArtistCollectionClosure, ArtistsView) {
                    var ArtistCollection = ArtistCollectionClosure(apiEndpoint);
                    
                    deferredBB.resolve([ArtistCollection, ArtistsView]);
            });


        // #2 Load templates here with my own loader (until a templating engine is used)
        // My templating loads non-compiled templates at runtime. Using it because
        // I'm not making builds for this developer demo.
        var templateSources = {
                'artist-item' : 'templates/artist.tpl'
            };
        templateLoader(templateSources, function(templates) {
            deferredTemplates.resolve(templates);
        });
        
        
        // #3 Load the Google API's client and OAuth2 modules.
        gapi.load('client:auth2', function(){
            initClient().then(function(){
                deferredGoogleAPI.resolve();
            });
        });
        
        $.when(
                deferredBB,
                deferredTemplates,
                deferredGoogleAPI)
        .then(function(resolve1, resolve2, resolve3) {
            var ArtistCollection = resolve1[0],
                ArtistsView = resolve1[1],
                templates = resolve2;

            // APP READY TO RUN

            // start up Backbone app, with the views and fetch
            var artists = new ArtistCollection();
            var artistsView = new ArtistsView({ itemTemplate: templates['artist-item'], collection: artists});
            artists.fetch();

            // bind event to input box so it refreshes search for albums after keyup for 300ms debounce
            $('#name').on('keyup', _.debounce(function (e) {
                //e.keyCode
                if (e.keyCode >= 32 && e.keyCode <= 127) {
                    artistsView.trigger('clearStatus');
                    artists
                            .fetch({data: {name: $('#name').val()}})
                            .then(function() {
                        });
                }
            }, 360));

            // Listen for sign-in state to change-- update ajaxSetup to include ID token for API
            GoogleAuth.isSignedIn.listen(function() {
                var user = GoogleAuth.currentUser.get();
                if (user.Zi !== null) {
                    $.ajaxSetup({
                        data: {
                            api_token: user.Zi.id_token
                        }
                    });
                    artistsView.trigger('clearInput');

                } else {
                    $.ajaxSetup({
                        data: {
                            api_token: "1" // invalid token
                        }
                    });
                }
                // BB fetch and update view
                artists.fetch();
            });
        });

        // the rest are functions google client...

        /**
         * 
         * @returns object "then" object
         */
        function initClient() {

            // Initialize the gapi.client object, which app uses to make API requests.
            // Get API key and client ID from API Console.
            // 'scope' field specifies space-delimited list of access scopes.
            return gapi.client.init({
                'apiKey': 'AIzaSyDNF2vPZkGaeVi2C5Cut6-w0ENitqEzUBQ',
                'discoveryDocs': [discoveryUrl],
                'clientId': '1068162703133-rvuj8ej1i6navlouq356tduot1f88jjt.apps.googleusercontent.com', // Client ID 2
                'scope': SCOPE
            }).then(function () {
                GoogleAuth = gapi.auth2.getAuthInstance();
                //console.log(GoogleAuth);
                // Listen for sign-in state changes.
                GoogleAuth.isSignedIn.listen(updateSigninStatus);

                // Handle initial sign-in state. (Determine if user is already signed in.)
                var user = GoogleAuth.currentUser.get();
                //console.log(user);
                // maybe user is already signed in at page load?
                if (user.Zi !== null) {
                    //console.log('Initialized page WITH TOKEN: ' + user.Zi.id_token);
                    $.ajaxSetup({
                        data: {
                            api_token: user.Zi.id_token
                        }
                    });
                } 
                setSigninStatus();

                // Call handleAuthClick function when user clicks on
                //      "Sign In/Authorize" button.
                $('#sign-in-or-out-button').click(function () {
                    handleAuthClick();
                });
                $('#revoke-access-button').click(function () {
                    revokeAccess();
                });
            });
        }

        function handleAuthClick() {
            if (GoogleAuth.isSignedIn.get()) {
                // User is authorized and has clicked 'Sign out' button.
                GoogleAuth.signOut();
                //console.log('sign-out');
            } else {
                // User is not signed in. Start Google auth flow.
                //console.log('sign-in');
                GoogleAuth.signIn();
            }
        }

        function revokeAccess() {
            GoogleAuth.disconnect();
        }

        function setSigninStatus(isSignedIn) {
            var user = GoogleAuth.currentUser.get();
            var isAuthorized = user.hasGrantedScopes(SCOPE);
            //console.log('authorized?');console.log(isAuthorized);
            if (isAuthorized) {
                $('#sign-in-or-out-button').html('Sign out');
                $('#revoke-access-button').css('display', 'inline-block');
                $('#auth-status').html('You are currently signed in and have granted ' +
                        'access to this app.');
            } else {
                $('#sign-in-or-out-button').html('Sign In/Authorize');
                $('#revoke-access-button').css('display', 'none');
                $('#auth-status').html('You have not authorized this app or you are ' +
                        'signed out.');
            }
        }

        function updateSigninStatus(isSignedIn) {
            setSigninStatus();
        }

    };


}));
