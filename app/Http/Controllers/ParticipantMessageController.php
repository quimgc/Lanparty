<?php

namespace App\Http\Controllers;

use App\Event;
use App\Jobs\SendParticipantMessage;
use App\ParticipantMessage;
use Illuminate\Http\Request;

class ParticipantMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Event $event)
    {

        $this->validate(request(),[
            'subject' => ['required'],
            'message' => ['required'],
        ]);

        $message = ParticipantMessage::create([
            'subject' => $request->subject,
            'message' => $request->message,
            'event_id' => $event->id
        ]);

        SendParticipantMessage::dispatch($message);

        return redirect()->route('manage.event-message.store', $event->id)
            ->with('flash','Your message has been sent!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ParticipantMessage  $participantMessage
     * @return \Illuminate\Http\Response
     */
    public function show(ParticipantMessage $participantMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ParticipantMessage  $participantMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(ParticipantMessage $participantMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ParticipantMessage  $participantMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ParticipantMessage $participantMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ParticipantMessage  $participantMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ParticipantMessage $participantMessage)
    {
        //
    }
}
