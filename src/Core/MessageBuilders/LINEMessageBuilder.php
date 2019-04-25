<?php

namespace Whchi\LaravelLineBotWrapper\Core\MessageBuilders;

use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use Whchi\LaravelLineBotWrapper\Core\Base;
use Whchi\LaravelLineBotWrapper\Core\MessageBuilders\FlexMessageBuilder\LINEFlexMessageBuilder;
use Whchi\LaravelLineBotWrapper\Core\MessageBuilders\Helpers\LINETemplateBuilderHelper;
use Whchi\LaravelLineBotWrapper\Exceptions\MessageBuilderException;

class LINEMessageBuilder extends Base
{
    /**
     * build button template
     *
     * @param array $template
     * @return ButtonTemplateBuilder
     */
    protected function buildButtonTemplateMessage(string $altText, array $template): TemplateMessageBuilder
    {
        $actions = $template['actions']->map(function ($action) {
            return LINETemplateBuilderHelper::getAction($action);
        })->toArray();

        $quickReply = LINETemplateBuilderHelper::buildQuickReply($template);

        $buttons = new ButtonTemplateBuilder(
            $template['title'],
            $template['text'],
            $template['thumbnailImageUrl'],
            $actions
        );
        $message = new TemplateMessageBuilder($altText, $buttons, $quickReply);
        return $message;
    }

    /**
     * build confirm template
     *
     * @param array $template
     * @return ConfirmTemplateBuilder
     */
    protected function buildConfirmTemplateMessage(string $altText, array $template): TemplateMessageBuilder
    {
        $actions = $template['actions']->map(function ($action) {
            return LINETemplateBuilderHelper::getAction($action);
        })->toArray();

        $quickReply = LINETemplateBuilderHelper::buildQuickReply($template);

        $buttons = new ConfirmTemplateBuilder(
            $template['text'],
            $actions
        );
        $message = new TemplateMessageBuilder($altText, $buttons, $quickReply);

        return $message;
    }

    /**
     * build carousel template
     *
     * @param array $template
     * @return CarouselTemplateBuilder
     */
    protected function buildCarouselTemplateMessage(string $altText, array $template): TemplateMessageBuilder
    {
        $columns = $template['columns']->map(function ($ele) {
            $title = $ele['title'];
            $text = $ele['text'];
            $image = $ele['thumbnailImageUrl'];
            $actions = $ele['actions']->map(function ($action) {
                return LINETemplateBuilderHelper::getAction($action);
            })->toArray();

            return new CarouselColumnTemplateBuilder($title, $text, $image, $actions);
        })->toArray();

        $quickReply = LINETemplateBuilderHelper::buildQuickReply($template);

        $carousel = new CarouselTemplateBuilder($columns);
        $message = new TemplateMessageBuilder($altText, $carousel, $quickReply);

        return $message;
    }

    protected function buildImageCarouselTemplateMessage(string $altText, array $template): TemplateMessageBuilder
    {
        $columns = $template['columns']->map(function ($ele) {
            $imageUri = $ele['imageUrl'];

            $action = LINETemplateBuilderHelper::getAction($ele['action']);
            return new ImageCarouselColumnTemplateBuilder($imageUri, $action);
        })->toArray();

        $quickReply = LINETemplateBuilderHelper::buildQuickReply($template);

        $imageCarousel = new ImageCarouselTemplateBuilder($columns);
        $message = new TemplateMessageBuilder($altText, $imageCarousel, $quickReply);

        return $message;
    }

    protected function buildImageMapMessage(string $altText, array $template): ImagemapMessageBuilder
    {
        $baseUrl = $template['baseUrl'];
        $baseSize = new BaseSizeBuilder(
            $template['baseSize']['width'],
            $template['baseSize']['height']
        );

        $imageMapActions = $template['actions']->map(function ($action) {
            $area = new AreaBuilder($action['area']['x'], $action['area']['y'], $action['area']['width'], $action['area']['height']);
            return LINETemplateBuilderHelper::getImageMapAction($action, $area);
        })->toArray();

        $quickReply = LINETemplateBuilderHelper::buildQuickReply($template);

        $message = new ImagemapMessageBuilder(
            $baseUrl,
            $altText,
            $baseSize,
            $imageMapActions,
            $quickReply
        );

        return $message;
    }

    protected function buildAudioMessage(array $template): AudioMessageBuilder
    {
        $quickReply = LINETemplateBuilderHelper::buildQuickReply($template);
        return new AudioMessageBuilder($template['originalContentUrl'], $template['duration'], $quickReply);
    }

    protected function buildVideoMessage(array $template): VideoMessageBuilder
    {
        $quickReply = LINETemplateBuilderHelper::buildQuickReply($template);
        return new VideoMessageBuilder($template['originalContentUrl'], $template['previewImageUrl'], $quickReply);
    }

    protected function buildImageMessage(array $template): ImageMessageBuilder
    {
        $quickReply = LINETemplateBuilderHelper::buildQuickReply($template);
        return new ImageMessageBuilder($template['originalContentUrl'], $template['previewImageUrl'], $quickReply);
    }

    protected function buildStickerMessage(array $template): StickerMessageBuilder
    {
        $quickReply = LINETemplateBuilderHelper::buildQuickReply($template);
        return new StickerMessageBuilder($template['packageId'], $template['stickerId'], $quickReply);
    }

    protected function buildLocationMessage(array $template): LocationMessageBuilder
    {
        $quickReply = LINETemplateBuilderHelper::buildQuickReply($template);
        return new LocationMessageBuilder(
            $template['title'],
            $template['address'],
            $template['lat'],
            $template['lon'],
            $quickReply
        );
    }

    protected function buildTextMessage(array $template): TextMessageBuilder
    {
        $quickReply = LINETemplateBuilderHelper::buildQuickReply($template);
        return new TextMessageBuilder($template['text'], $quickReply);
    }

    protected function buildMultiMessages(string $altText, array $messageList): MultiMessageBuilder
    {
        if (count($messageList) > 5) {
            throw new MessageBuilderException('You can only combine 5 messages at a time');
        }

        $builder = new MultiMessageBuilder();

        foreach ($messageList as $message) {
            switch ($message['type']) {
                case 'text':
                    $builder->add($this->buildTextMessage($message));
                    break;
                case 'sticker':
                    $builder->add($this->buildStickerMessage($message));
                    break;
                case 'button':
                    $builder->add($this->buildButtonTemplateMessage($altText, $message));
                    break;
                case 'confirm':
                    $builder->add($this->buildConfirmTemplateMessage($altText, $message));
                    break;
                case 'imagemap':
                    $builder->add($this->buildImageMapMessage($altText, $message));
                    break;
                case 'image':
                    $builder->add($this->buildImageMessage($message));
                    break;
                case 'image_carousel':
                    $builder->add($this->buildImageCarouselTemplateMessage($altText, $message));
                    break;
                case 'carousel':
                    $builder->add($this->buildCarouselTemplateMessage($altText, $message));
                    break;
                case 'audio':
                    $builder->add($this->buildAudioMessage($message));
                    break;
                case 'video':
                    $builder->add($this->buildVideoMessage($message));
                    break;
                case 'location':
                    $builder->add($this->buildLocationMessage($message));
                    break;
                default:
                    throw new MessageBuilderException('Invalid message type');
            }
        }
        return $builder;
    }

    protected function buildFlexMessage(string $altText, array $template): FlexMessageBuilder
    {
        $flex = new LINEFlexMessageBuilder($template['type']);
        $flex->createComponents($template);
        $container = $flex->getContainer();

        $quickReply = LINETemplateBuilderHelper::buildQuickReply($template);

        $builder = new FlexMessageBuilder($altText, $container, $quickReply);
        return $builder;
    }
}
