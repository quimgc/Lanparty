<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class UsersControllerTest
 * @package Tests\Feature
 */
class UsersControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_retrieve_all_users()
    {
        factory(User::class,5)->create();
        $response = $this->json('GET','api/v1/users');
        $response->assertSuccessful();
        $this->assertCount(5,json_decode($response->getContent()));
        $response->assertJsonStructure([[
            'id',
            'name',
            'email',
            'givenName',
            'sn1',
            'sn2',
            'formatted_created_at_date',
            'full_search',
            'numbers',
        ]]);
    }
}
