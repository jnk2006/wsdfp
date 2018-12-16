<?php

namespace Tests\BotMan;

use Tests\TestCase;

class QuestionConversationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testEntireQuestionTest()
    {
        $this->bot->receives('Hi')
            ->assertReply('Hi! Can I help you with anything today?')->receives('yes')
            ->assertReply('Sure!')
            ->assertQuestion('Do you know the entire question?')
            ->receivesInteractiveMessage('Yes')
            ->assertReply('Ask the question');
    }

    public function testPartialQuestionTest()
    {
        $this->bot->receives('Hi')
            ->assertReply('Hi! Can I help you with anything today?')->receives('yes')
            ->assertReply('Sure!')
            ->assertQuestion('Do you know the entire question?')
            ->receivesInteractiveMessage('No')
            ->assertReply('Enter the keywords:');
    }
}
