var Vue = require('vue');

var utils = require('./utils');

Vue.component('select-category', require('./components/select-category.vue'));

Vue.component('note-row', require('./components/note-row.vue'));

var App = require('./components/app.vue');

var vm = new Vue({
    el: '#main',
    components: {
        app: App
    }
});






