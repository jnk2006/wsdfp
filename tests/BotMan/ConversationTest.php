<?php

namespace Tests\BotMan;

use Tests\TestCase;

class ConversationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStartTest()
    {
        $this->bot->receives('Hi')
            ->assertReply('Hi! Can I help you with anything today?')->receives('yes')
            ->assertReply('Sure!');
    }

}
