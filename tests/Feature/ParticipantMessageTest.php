<?php

namespace Tests\Feature;

use App\Event;
use App\Jobs\SendParticipantMessage;
use App\ParticipantMessage;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use Illuminate\Database;

class ParticipantMessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_manager_can_send_a_new_message()
    {
//        $this->disableExceptionHandling();
        $this->withoutExceptionHandling();

        Queue::fake();

        $user = factory(User::class)->create();
        $event = Event::create([
            'name' => 'League Of Legends',
            'inscription_type_id' => 1,
            'image' => 'img/LoL.jpeg',
//            'tickets' => 10, // Número de grups,
//            'reglament' => 'https://docs.google.com/document/d/1lO-twh_U-wGS7jNQJu_B6yhqq-E5RbQacOX-3AiRZmA/edit',
//            'published_at' => '2018-01-15 12:00:00'
        ]);


        $response = $this->actingAs($user)->post("/manage/events/{$event->id}/messages", [
            'subject' => 'My subject',
            'message' => 'My message',
        ]);

        $message = ParticipantMessage::first();

        $this->assertEquals('My subject', $message->subject);
        $this->assertEquals('My message', $message->message);
        $this->assertEquals($event->id, $message->event_id);

        $response->assertRedirect("/manage/events/{$event->id}/messages");
        $response->assertSessionHas('flash', 'Your message has been sent!');

//        Queue::assertPushed(SendParticipantMessage::class);

        Queue::assertPushed(SendParticipantMessage::class, function ($job) use ($message) {
//            return $job->message === $message->id;
            return $job->message->is($message);
        });


    }
}
