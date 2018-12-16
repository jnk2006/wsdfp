<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use Illuminate\Support\Facades\DB;

class EntireQuestionConversation extends Conversation
{
    public function askEntire()
    {
        $this->ask('Ask the question', function(Answer $answer) {
            $this->bot->userStorage()->save([
                'equestion' => $answer->getText(),
            ]);

            $qid = DB::table('questions')
                ->select('*')
                ->where('body', 'like', '%'. $answer .'%')
                ->get()
                ->first();
            $link = route('question.show', ['id' => $qid->id]);
            $this->say(' ' . $link);
            $this->bot->startConversation(new ThankYouConversation());
        });
    }

    public function run()
    {
        $this->askEntire();
    }
}