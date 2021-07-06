<?php

namespace Whchi\LaravelLineBotWrapper\Constant;

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
