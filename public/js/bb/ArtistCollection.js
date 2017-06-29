
define(['bb-artist-model', 'backbone'], function (ArtistModel, BB) {
    // need a closure to get apiEndpoint later...
    return function (apiEndpoint) {
        return BB.Collection.extend({
            url: apiEndpoint + '/search?type=artist',
            model: ArtistModel,
            parse: function (data) {
                this.userName = data.user.name;
                return data.data;
            }
        });
    };

});
