<?php

namespace Whchi\LaravelLineBotWrapper\Exceptions;

use Exception;

class LINEBotException extends Exception
{
    const ERROR_CODE = 9;

    public function __construct(string $message)
    {
        parent::__construct(get_called_class() . ', ' . $message, static::ERROR_CODE);
    }
}
