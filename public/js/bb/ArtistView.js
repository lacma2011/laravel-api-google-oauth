define(['backbone'], function (BB) {
    return BB.View.extend({
        tagName: 'tr',
        className: 'artist',

        template: null,

        initialize: function (options) {
            this.template = _.template(options.template);
            this.listenTo(this.model, 'destroy', this.remove);
        },

        render: function () {
            var data = this.model.toJSON();
            var html = this.template(data);
            this.$el.html(html);
            return this;
        },

        events: {

        },

        onRemove: function () {
            this.model.destroy();
        }
    });
});



