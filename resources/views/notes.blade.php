@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Styde.net / Curso de VueJS</h1>

            <div class="alert_container">
                <p v-show="alert.display"
                   class="alert alert-danger"
                   id="error_message"
                   transition="fade">@{{ alert.message }}</p>
            </div>

            <table class="table table-striped">
                <tr>
                    <th>Categoría</th>
                    <th>Nota</th>
                    <th width="50px">&nbsp;</th>
                </tr>
                <tr v-for="note in notes"
                    is="note-row"
                    :note="note"
                    :categories="categories"
                    @update-note="updateNote"
                    @delete-note="deleteNote"></tr>
                <tr>
                    <td><select-category :categories="categories" :id.sync="new_note.category_id"></select-category></td>
                    <td>
                        <input type="text" v-model="new_note.note" class="form-control">
                        <ul v-if="errors.length" class="text-danger">
                            <li v-for="error in errors">@{{ error }}</li>
                        </ul>
                    </td>
                    <td>
                        <a href="#" @@click.prevent="createNote()">
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <pre>@{{ $data | json }}</pre>
@endsection

@section('scripts')
    <style>
        .fade-transition {
            transition: all 1s ease;
            opacity: 100;
        }
        .fade-enter, .fade-leave {
            opacity: 0;
        }

        .alert_container {
            height: 60px;
        }
    </style>

    <script type="text/javascript" src="js/main.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.1/animate.min.css">
@endsection