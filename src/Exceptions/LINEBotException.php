<?php

namespace Whchi\LaravelLineBotWrapper\Exceptions;

class LINEBotException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
