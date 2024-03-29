<?php


namespace Whchi\LaravelLineBotWrapper\MessageBuilders;

use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImageMap\ExternalLinkBuilder;
use LINE\LINEBot\MessageBuilder\ImageMap\VideoBuilder;
use LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder;
use LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder\CameraRollTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\CameraTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\LocationTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use Whchi\LaravelLineBotWrapper\Exceptions\MessageBuilderException;

class Base
{
    /**
     * @throws MessageBuilderException
     */
    protected function buildQuickReply(array $template): ?QuickReplyMessageBuilder
    {
        $quickReply = null;

        if (isset($template['quickReply']) && count($template['quickReply']) < 13) {
            $quickReplyButtons = [];
            foreach ($template['quickReply']['items'] as $item) {
                if ($item['type'] !== 'action') {
                    continue;
                }
                $action = $this->makeAction($item['action']);
                array_push($quickReplyButtons, new QuickReplyButtonBuilder($action, $item['imageUrl']));
            }
            $quickReply = new QuickReplyMessageBuilder($quickReplyButtons);
        }

        return $quickReply;
    }

    /**
     * @throws MessageBuilderException
     */
    public function makeAction(array $action, bool $isImageCarousel = false)
    {
        if ($isImageCarousel) {
            $action['label'] = $action['label'] ?? null;
            if (mb_strlen($action['label']) > 12) {
                throw new MessageBuilderException('label size exceed limit, max: 12');
            }
        }
        if (mb_strlen($action['label']) > 20) {
            throw new MessageBuilderException('label size exceed limit, max: 20');
        }

        switch ($action['type']) {
            case 'postback':
                return new PostbackTemplateActionBuilder($action['label'], $action['data'], $action['displayText']);
            case 'uri':
                return new UriTemplateActionBuilder($action['label'], $action['uri']);
            case 'message':
                return new MessageTemplateActionBuilder($action['label'], $action['text']);
            case 'datetimepicker':
                $action['initial'] = $action['initial'] ?? null;
                $action['max'] = $action['max'] ?? null;
                $action['min'] = $action['min'] ?? null;
                return new DatetimePickerTemplateActionBuilder(
                    $action['label'],
                    $action['data'],
                    $action['mode'],
                    $action['initial'],
                    $action['max'],
                    $action['min']
                );
            case 'cameraRoll':
                return new CameraRollTemplateActionBuilder($action['label']);
            case 'camera':
                return new CameraTemplateActionBuilder($action['label']);
            case 'location':
                return new LocationTemplateActionBuilder($action['label']);
            default:
                throw new MessageBuilderException('Invalid template action type');
        }
    }

    /**
     * @throws MessageBuilderException
     */
    public function getImageMapAction(array $action)
    {
        $area = $action['area'];
        $area = new AreaBuilder($area['x'], $area['y'], $area['width'], $area['height']);

        switch ($action['type']) {
            case 'uri':
                return new ImagemapUriActionBuilder($action['linkUri'], $area);
            case 'message':
                return new ImagemapMessageActionBuilder($action['text'], $area);
            default:
                throw new MessageBuilderException('Invalid image map action type');
        }
    }

    public function getImageMapBaseSize(array $template): BaseSizeBuilder
    {
        return new BaseSizeBuilder(
            $template['height'],
            $template['width']
        );
    }

    public function getImageMapVideoBuilder(array $template): VideoBuilder
    {
        return new VideoBuilder(
            $template['originalContentUrl'],
            $template['previewImageUrl'],
            new AreaBuilder(
                $template['area']['x'],
                $template['area']['y'],
                $template['area']['height'],
                $template['area']['width']
            ),
            new ExternalLinkBuilder($template['externalLink']['linkUri'], $template['externalLink']['label'])
        );
    }
}
