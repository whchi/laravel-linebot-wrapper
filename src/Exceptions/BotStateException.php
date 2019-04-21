<?php

namespace Whchi\LaravelLineBotWrapper\Exceptions;

class BotStateException extends LINEBotException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
