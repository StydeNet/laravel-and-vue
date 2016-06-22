var Vue = require('vue');

var utils = require('./utils');

Vue.transition('bounce-out', {
    leaveClass: 'bounceOut'
})

Vue.filter('category', function (id) {
    var category = utils.findById(this.categories, id);

    return category != null ? category.name : '';
});

Vue.component('select-category', require('./components/select-category.vue'));

Vue.component('note-row', require('./components/note-row.vue'));

var App = require('./components/app.vue');

var vm = new Vue({
    el: 'body',
    components: {
        app: App
    }
});






