<template>
    <tr class="animated">
        <template v-if="! editing">
            <td>{{ category_name }}</td>
            <td>{{ note.note }}</td>
            <td>
                <a href="#" @click.prevent="edit()"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                <a href="#" @click.prevent="remove()">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </a>
            </td>
        </template>
        <template v-else>
            <td>
                <select-category :categories="categories" :note="draft"></select-category>
            </td>
            <td>
                <input type="text" v-model="draft.note" class="form-control">
                <ul v-if="errors.length" class="text-danger">
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </td>
            <td>
                <a href="#" @click.prevent="update()">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </a>
                <a href="#" @click.prevent="cancel()">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </a>
            </td>
        </template>
    </tr>
</template>

<script>
var utils = require('./../utils');

export default {
    props: ['note', 'categories'],
    data: function() { 
        return {
            editing: false,
            errors: [],
            draft: {}
        };
    },
    computed: {
        category_name: function () {
            var category = utils.findById(this.categories, this.note.category_id);

            return category != null ? category.name : '';
        }
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

            this.$emit('update-note', this);
        },
        remove: function () {
            this.$emit('delete-note', this.note);
        }
    }
}
</script>