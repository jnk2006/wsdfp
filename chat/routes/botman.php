<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('Hello|Hi', BotManController::class.'@startConversation');

$botman->hears('Start Conversation', BotManController::class. '@jokeConversation');