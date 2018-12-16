<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use Illuminate\Support\Facades\Auth;

class StartConversation extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */

    public function askDoubt()
    {
        $this->ask('Hi! Can I help you with anything today?', function(Answer $answer) {
            $this->bot->userStorage()->save([
                'doubt' => $answer->getText(),
            ]);

            $this->say('Sure!');
            $this->bot->startConversation(new SelectQuestionConversation());
        });
    }

    public function run()
    {
        $this->askDoubt();
    }
}
