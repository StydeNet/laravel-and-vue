<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    function testExample()
    {
        factory(\App\User::class)->create(['name' => 'Duilio']);

        $this->get('name')
            ->assertResponseOk();

        $this->seeText('Duilio');
    }
}
