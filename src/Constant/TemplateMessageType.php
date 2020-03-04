<?php

namespace Whchi\LaravelLineBotWrapper\Constant;

use Whchi\LaravelLineBotWrapper\Abstracts\InteractWithAttribute;

class TemplateMessageType extends InteractWithAttribute
{
    const CONFIRM = 'confirm';
    const BUTTONS = 'buttons';
    const CAROUSEL = 'carousel';
    const IMAGE_CAROUSEL = 'image_carousel';
    const IMAGEMAP = 'imagemap';
    const FLEX = 'flex';
}
