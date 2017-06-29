define(['bb-artist-view', 'backbone'], function (ArtistView, BB) {
    return BB.View.extend({
        el: '.searchbox',
        initialize: function (options) {
            _.bindAll(this, 'render');
            this.listenTo(this.collection, 'sync', this.render);
            this.collection.on('error', this.defaultErrorHandler, this);
            this.collection.on('update', this.clearStatus, this);
            this.on('clearInput', this.clearInput, this);
            this.on('clearStatus', this.clearStatus, this);
            this.artistTemplate = options.itemTemplate;
        },

        render: function () {
            var $list = this.$('table.artists').empty();
            $list.append('<tr><th>Name</th><th>Handle</th></tr>');
            this.$('.api-message')
                    .html(this.collection.length + ' found <br> Logged In: ' + this.collection.userName);

            this.collection.each(function (model) {
                var item = new ArtistView({model: model, template: this.artistTemplate});
                $list.append(item.render().$el);
            }, this);
            return this;
        },

        defaultErrorHandler: function (model, error) {
            this.$('table.artists').empty();
            var text = 'API error: "' + error.responseJSON.error + '" (HTTP ' + error.status + ')';
            this.$('.api-message').text(text);
        },

        clearStatus: function () {
            this.$('.api-message').text('');
        },

        clearInput: function () {
            this.$('#name').val('');
        }
    });
});



