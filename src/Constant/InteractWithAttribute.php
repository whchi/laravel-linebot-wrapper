<?php

namespace Whchi\LaravelLineBotWrapper\Abstracts;

use ReflectionClass;

class InteractWithAttribute
{
    /**
     * @throws \ReflectionException
     */
    final public static function getConstants(): array
    {
        return (new ReflectionClass(get_called_class()))->getConstants();
    }
}
