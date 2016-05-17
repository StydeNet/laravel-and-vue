<?php

Route::resource('notes', 'NoteController', [
    'parameters' => [
        'notes' => 'note'
    ]
]);