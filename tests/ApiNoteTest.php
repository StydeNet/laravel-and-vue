<?php

use App\Note;
use App\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiNoteTest extends TestCase
{
    use DatabaseTransactions;

    function test_list_notes()
    {
        $category = factory(Category::class)->create();

        $notes = factory(Note::class)->times(2)->create([
            'category_id' => $category->id,
            'note' => 'Esta es una nota'
        ]);

        $this->get('api/v1/notes')
            ->assertResponseOk() // 200
            ->seeJsonEquals(Note::all()->toArray());
    }
}
