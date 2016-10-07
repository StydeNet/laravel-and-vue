<template>
    <div>
        <transition name="fade">
            <div class="alert_container">
                <p v-show="alert.display"
                   class="alert alert-danger"
                   id="error_message">{{ alert.message }}</p>
            </div>
        </transition>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th>Nota</th>
                    <th width="50px">&nbsp;</th>
                </tr>
            </thead>
            <transition-group tag="tbody" leave-active-class="bounceOut">
                <tr v-for="note in notes"
                    :key="note.id"
                    is="note-row"
                    :note="note"
                    :categories="categories"
                    @update-note="updateNote"
                    @delete-note="deleteNote"></tr>
            </transition-group>
            <tfoot>
                <tr>
                    <td><select-category :categories="categories" :note="new_note"></select-category></td>
                    <td>
                        <input type="text" v-model="new_note.note" class="form-control">
                        <ul v-if="errors && errors.length" class="text-danger">
                            <li v-for="error in errors">{{ error }}</li>
                        </ul>
                    </td>
                    <td>
                        <a href="#" @click.prevent="createNote()">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
var Vue = require('vue');

Vue.use(require('vue-resource'));

var resource;

var utils = require('./../utils');

export default {
    data: function () {
        return {
            new_note: {
                note: '',
                category_id: ''
            },
            notes: [],
            errors: [],
            alert: {
                message: '',
                display: false
            },
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
        }
    },
    mounted: function () {
        resource = this.$resource('/api/v1/notes{/id}');

        resource.get().then(function (response) {
            this.notes = response.data;
        });

        Vue.http.interceptors.push(function (request, next) {
            var token = document.getElementById('token').getAttribute('content');

            request.headers.set('X-CSRF-TOKEN', token);

            next(function (response) {
                if (response.ok) {
                    return response;
                }

                this.alert.message = response.data.message;
                this.alert.display = true;

                setTimeout(function () {
                    this.alert.display = false;
                }.bind(this), 4000);

                return response;
            });
        });
    },
    methods: {
        createNote: function () {
            this.errors = [];

            resource.save({}, this.new_note).then(function (response) {
                this.notes.push(response.data.note);
            }, function (response) {
                this.errors = response.data.errors;
            });

            this.new_note = {note: '', category_id: ''};
        },
        deleteNote: function (note) {
            resource.delete({id: note.id}).then(function (response) {
                var index = this.notes.indexOf(note);

                this.notes.splice(index, 1);
            });
        },
        updateNote: function (component) {
            resource.update({id: component.note.id}, component.draft).then(function (response) {
                utils.assign(component.note, response.data.note);

                component.editing = false;
            }, function (response) {
                component.errors = response.data.errors;
            });
        }
    },
    filters: {
    }
}
</script>