define(['backbone'], function (BB) {
    return BB.Model.extend({
        defaults: {
            name: '',
            handle: ''
        }
    });
});

