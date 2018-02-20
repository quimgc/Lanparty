<?php

namespace Tests\Unit;

use App\Event;
use App\Jobs\SendParticipantMessage;
use App\Mail\ParticipantMessageEmail;
use App\ParticipantMessage;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendParticipantMessageTest extends TestCase
{
 /**
  * @test
  */
use RefreshDatabase;
    public function it_sends_message_to_all_event_participants()
    {

        Mail::fake();

        $event = Event::create([
            'name' => 'League Of Legends',
            'inscription_type_id' => 1,
            'image' => 'img/LoL.jpeg',
//            'tickets' => 10, // Número de grups,
//            'reglament' => 'https://docs.google.com/document/d/1lO-twh_U-wGS7jNQJu_B6yhqq-E5RbQacOX-3AiRZmA/edit',
//            'published_at' => '2018-01-15 12:00:00'
        ]);

        //prepare
        $message = ParticipantMessage::create([
            'subject' => 'Patata',
            'message' => 'Comprar pataques company',
            'event_id' => $event->id
        ]);

        //execute
        SendParticipantMessage::dispatch($message);

        //Assert

//        Mail::assertSent(ParticipantMessageEmail::class);
        Mail::assertSent(ParticipantMessageEmail::class, function ($mail) use ($message) {

//            return $mail->order->id === $order->id;
            return $mail->message->is($message);

        });



    }
}
