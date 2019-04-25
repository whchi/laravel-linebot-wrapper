<?php

namespace Whchi\LaravelLineBotWrapper\Core\MessageBuilders\Helpers;

use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder;
use LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use Whchi\LaravelLineBotWrapper\Exceptions\MessageBuilderException;

class LINETemplateBuilderHelper
{
    const QUICK_REPLY_LIMIT = 13;

    public static function buildQuickReply(array $template)
    {
        $quickReply = null;

        if (isset($template['quickReply']) && count($template['quickReply']) < self::QUICK_REPLY_LIMIT) {
            $quickReplyButtons = $template['quickReply']['items']->map(function ($ele) {
                if ($ele['type'] !== 'action') {
                    return null;
                }
                $action = self::getAction($ele['action']);
                return new QuickReplyButtonBuilder($action, $ele['imageUrl']);
            })->toArray();
            $quickReply = new QuickReplyMessageBuilder($quickReplyButtons);
        }

        return $quickReply;
    }

    public static function getAction(array $action)
    {
        if (!isset($action['label'])) {
            $action['label'] = null;
        }

        switch ($action['type']) {
            case 'postback':
                return new PostbackTemplateActionBuilder($action['label'], $action['data'], $action['displayText']);
            case 'uri':
                return new UriTemplateActionBuilder($action['label'], $action['uri']);
            case 'message':
                return new MessageTemplateActionBuilder($action['label'], $action['text']);
            default:
                throw new MessageBuilderException('Invalid template action type');
        }
    }

    public static function getImageMapAction(array $action, AreaBuilder $area)
    {
        switch ($action['type']) {
            case 'uri':
                return new ImagemapUriActionBuilder($action['linkUri'], $area);
            case 'message':
                return new ImagemapMessageActionBuilder($action['text'], $area);
            default:
                throw new MessageBuilderException('Invalid image map action type');
        }
    }
}
