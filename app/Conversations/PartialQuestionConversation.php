<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use Illuminate\Support\Facades\DB;

class PartialQuestionConversation extends Conversation
{
    public function askPartial()
    {
        $this->ask('Enter the keywords:', function(Answer $answer) {
            $this->bot->userStorage()->save([
                'pquestion' => $answer->getText(),
            ]);

            $qids = DB::table('questions')
                ->select('*')
                ->where('body', 'like', '%'. $answer .'%')
                ->get();
            $links = array();
            foreach ($qids as $qid)
            {
                $links = route('question.show', ['id' => $qid->id]);
                $this->say(' ' . $links);
            }

            $this->bot->startConversation(new ThankYouConversation());
        });
    }

    public function run()
    {
        $this->askPartial();
    }
}