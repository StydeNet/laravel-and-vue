@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Styde.net / Curso de VueJS / Lección 10</h1>

            <table class="table table-striped">
                <tr>
                    <th>Categoría</th>
                    <th>Nota</th>
                    <th width="50px">&nbsp;</th>
                </tr>
                <tr v-for="note in notes" is="note-row" :note.sync="note" :categories="categories"></tr>
                <tr>
                    <td><select-category :categories="categories" :id.sync="new_note.category_id"></select-category></td>
                    <td><input type="text" v-model="new_note.note" class="form-control"></td>
                    <td>
                        <a href="#" @@click="createNote()">
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
    @verbatim
    <template id="select_category_tpl">
        <select v-model="id" class="form-control">
            <option value="">- Selecciona una categoría</option>
            <option v-for="category in categories" :value="category.id">
                {{ category.name }}
            </option>
        </select>
    </template>

    <template id="note_row_tpl">
        <tr>
            <template v-if="! editing">
                <td>{{ note.category_id | category }}</td>
                <td>{{ note.note }}</td>
                <td>
                    <a href="#" @click="edit()"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                    <a href="#" @click="remove()">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </a>
                </td>
            </template>
            <template v-else>
                <td>
                    <select-category :categories="categories" :id.sync="note.category_id"></select-category>
                </td>
                <td><input type="text" v-model="note.note" class="form-control"></td>
                <td><a href="#" @click="update()"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a></td>
            </template>
        </tr>
    </template>
    @endverbatim

    <script src="https://code.jquery.com/jquery-2.2.3.js"
            integrity="sha256-laXWtGydpwqJ8JA+X9x2miwmaiKhn8tVmOVEigRNtP4="
            crossorigin="anonymous"></script>
    <script src="{{ url('js/vue.js') }}"></script>
    <script src="{{ url('js/notes.js') }}"></script>
@endsection