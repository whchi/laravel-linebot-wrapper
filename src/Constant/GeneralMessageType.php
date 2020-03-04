<?php

namespace Whchi\LaravelLineBotWrapper\Constant;

use Whchi\LaravelLineBotWrapper\Abstracts\InteractWithAttribute;

class GeneralMessageType extends InteractWithAttribute
{
    const TEXT = 'text';
    const STICKER = 'sticker';
    const LOCATION = 'location';
    const IMAGE = 'image';
    const AUDIO = 'audio';
    const VIDEO = 'video';
}
