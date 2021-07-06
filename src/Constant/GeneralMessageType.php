<?php

namespace Whchi\LaravelLineBotWrapper\Constant;

use Whchi\LaravelLineBotWrapper\Abstracts\InteractWithAttribute;

class GeneralMessageType extends InteractWithAttribute
{
    public const TEXT = 'text';
    public const STICKER = 'sticker';
    public const LOCATION = 'location';
    public const IMAGE = 'image';
    public const AUDIO = 'audio';
    public const VIDEO = 'video';
}
