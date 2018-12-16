<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;

class SelectQuestionConversation extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function askQuestion()
    {
        $question = Question::create('Do you know the entire question?')
            ->callbackId('Select one from below:')
            ->addButtons([
                Button::create('Yes')->value('Yes'),
                Button::create('No')->value('No'),
            ]);

        $this->ask($question, function(Answer $answer) {
            if($answer->isInteractiveMessageReply()) {
                $this->bot->userStorage()->save([
                    'question' => $answer->getValue(),
                ]);
            }
            switch($answer)
            {
                case "Yes":
                case "yes":
                    $this->bot->startConversation(new EntireQuestionConversation());
                    break;

                case "No":
                case "no":
                    $this->bot->startConversation(new PartialQuestionConversation());
                    break;

                default:
                    $this->say('Try asking again');
                    $this->bot->startConversation(new SelectQuestionConversation());

            }

        });
    }

    public function run()
    {
        $this->askQuestion();
    }
}