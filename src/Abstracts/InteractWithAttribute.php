<?php

namespace Whchi\LaravelLineBotWrapper\Abstracts;

use ReflectionClass;

abstract class InteractWithAttribute
{
    final public static function getConstants()
    {
        return (new ReflectionClass(get_called_class()))->getConstants();
    }
}
