<?php

namespace Tests\Feature;

use App\Invitation;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InviteManagerTest extends TestCase
{

    use RefreshDatabase;
    /**
     * @test
     */
    public function invite_manager_via_cli()
    {

        //prepare

        //execute

        $this->artisan('invite-manager', [
            'email' => 'pepitodelospalotes@gmail.com'
        ]);

        //Invitation: email, code
        $invitation = Invitation::first();

        $this->assertEquals('pepitodelospalotes@gmail.com', $invitation->email);
        //$this->assertEquals('INVITATIONCODE_123', $invitation->code);
        Hash::check('hola', $invitation->code);

        //Comprovar que s'ha enviat un email


    }
}
