<?php

namespace Whchi\LaravelLineBotWrapper\Exceptions;

class MessageBuilderException extends LINEBotException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
