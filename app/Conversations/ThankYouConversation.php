<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;

class ThankYouConversation extends Conversation
{
    public function conveyThanks()
    {
        $this->askAnotherQuestion();
    }

    public function askAnotherQuestion()
    {
        $question = Question::create('Can I help you with anything else?')
            ->callbackId('Select one from below:')
            ->addButtons([
                Button::create('Yes')->value('Yes'),
                Button::create('No')->value('No'),
            ]);

        $this->ask($question, function(Answer $answer) {
            if($answer->isInteractiveMessageReply()) {
                $this->bot->userStorage()->save([
                    'aquestion' => $answer->getValue(),
                ]);
            }

            if($answer == 'Yes')
            {
                $this->bot->startConversation(new SelectQuestionConversation());
            }

            else
            {
                $this->say('Have a great day!');
            }
        });
    }

    public function run()
    {
        $this->conveyThanks();
    }
}