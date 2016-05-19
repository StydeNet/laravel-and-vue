function findById(items, id) {
    for (var i in items) {
        if (items[i].id == id) {
            return items[i];
        }
    }

    return null;
}

Vue.filter('category', function (id) {
    var category = findById(this.categories, id);

    return category != null ? category.name : '';
});

Vue.component('select-category', {
    template: "#select_category_tpl",
    props: ['categories', 'id']
});

Vue.component('note-row', {
    template: "#note_row_tpl",
    props: ['note', 'categories'],
    data: function() { 
        return {
            editing: false,
            errors: [],
            draft: {}
        };
    },
    methods: {
        edit: function () {
            this.errors = [];

            this.draft = JSON.parse(JSON.stringify(this.note));

            this.editing = true;
        },
        cancel: function () {
            this.editing = false;
        },
        update: function () {

            this.errors = [];

            $.ajax({
                url: '/api/v1/notes/'+this.note.id,
                method: 'PUT',
                dataType: 'json',
                data: this.draft,
                success: function (data) {
                    this.$parent.notes.$set(this.$parent.notes.indexOf(this.note), data.note);

                    this.editing = false;
                }.bind(this),
                error: function (jqXHR) {
                    this.errors = jqXHR.responseJSON.errors;
                }.bind(this)
            });
        },
        remove: function () {

            $.ajax({
                url: '/api/v1/notes/'+this.note.id,
                method: 'DELETE',
                dataType: 'json',
                success: function (data) {
                    this.$parent.notes.$remove(this.note);
                }.bind(this)
            });

        }
    }
});

var vm = new Vue({
    el: 'body',
    data: {
        new_note: {
            note: '',
            category_id: ''
        },
        notes: [],
        errors: [],
        error: '',
        categories: [
            {
                id: 1,
                name: 'Laravel'
            },
            {
                id: 2,
                name: 'Vue.js'
            },
            {
                id: 3,
                name: 'Publicidad'
            }
        ]
    },
    ready: function () {
        $.getJSON('/api/v1/notes', [], function (notes) {
            vm.notes = notes;
        });

        $(document).ajaxError(function (event, jqXHR) {
            this.error = jqXHR.responseJSON.message;

            $('#error_message').delay(3000).fadeOut(1000, function () {
                this.error = '';
            });
        }.bind(this));
    },
    methods: {
        createNote: function () {

            this.errors = [];

            $.ajax({
                url: '/api/v1/notes',
                method: 'POST',
                data: this.new_note,
                dataType: 'json',
                success: function (data) {
                    vm.notes.push(data.note);
                },
                error: function (jqXHR) {
                    vm.errors = jqXHR.responseJSON.errors;
                }
            });

            this.new_note = {note: '', category_id: ''};
        }
    },
    filters: {
    }
});




