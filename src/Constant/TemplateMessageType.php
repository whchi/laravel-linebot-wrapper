<?php

namespace Whchi\LaravelLineBotWrapper\Constant;

use Whchi\LaravelLineBotWrapper\Abstracts\InteractWithAttribute;

class TemplateMessageType extends InteractWithAttribute
{
    public const CONFIRM = 'confirm';
    public const BUTTONS = 'buttons';
    public const CAROUSEL = 'carousel';
    public const IMAGE_CAROUSEL = 'image_carousel';
    public const IMAGEMAP = 'imagemap';
    public const FLEX = 'flex';
}
