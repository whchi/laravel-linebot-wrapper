<?php

namespace Whchi\LaravelLineBotWrapper\MessageBuilders;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
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
use Whchi\LaravelLineBotWrapper\Constant\FlexBoxElement;
use Whchi\LaravelLineBotWrapper\Constant\GeneralMessageType;
use Whchi\LaravelLineBotWrapper\Constant\TemplateMessageType;
use Whchi\LaravelLineBotWrapper\Exceptions\MessageBuilderException;

class LINEMessageBuilder extends Base
{

    const MULTI_MESSAGE_LIMIT = 5;

    /**
     * @throws MessageBuilderException
     */
    private function validate(array $ipt, array $rule)
    {
        $validator = Validator::make($ipt, $rule);
        if ($validator->fails()) {
            throw new MessageBuilderException($validator->errors()
                                                        ->__toString());
        }
    }

    /**
     * build button template
     *
     * @param string $altText
     * @param array $template
     * @return TemplateMessageBuilder
     * @throws MessageBuilderException
     */
    protected function buildButtonMessage(string $altText, array $template): TemplateMessageBuilder
    {
        $this->validate($template, ['actions' => 'required|array']);

        $actions = [];

        foreach ($template['actions'] as $action) {
            array_push($actions, $this->getAction($action));
        }

        $template['title'] = $template['title'] ?? null;
        $template['thumbnailImageUrl'] = $template['thumbnailImageUrl'] ?? null;
        $template['imageAspectRatio'] = $template['imageAspectRatio'] ?? null;
        $template['imageSize'] = $template['imageSize'] ?? null;
        $template['imageBackgroundColor'] = $template['imageBackgroundColor'] ?? null;
        $defaultAction = (isset($template['defaultAction']))
            ? $this->getAction($template['defaultAction'])
            : null;

        $quickReply = $this->buildQuickReply($template);

        $buttons = new ButtonTemplateBuilder(
            $template['title'],
            $template['text'],
            $template['thumbnailImageUrl'],
            $actions,
            $template['imageAspectRatio'],
            $template['imageSize'],
            $template['imageBackgroundColor'],
            $defaultAction
        );
        return new TemplateMessageBuilder($altText, $buttons, $quickReply);
    }

    /**
     * build confirm template
     *
     * @param string $altText
     * @param array $template
     * @return TemplateMessageBuilder
     * @throws MessageBuilderException
     */
    protected function buildConfirmMessage(string $altText, array $template): TemplateMessageBuilder
    {
        $this->validate($template, ['actions' => 'required|array|max:2', 'text' => 'required|max:240']);
        $actions = [];

        foreach ($template['actions'] as $action) {
            array_push($actions, $this->getAction($action));
        }

        $quickReply = $this->buildQuickReply($template);

        $buttons = new ConfirmTemplateBuilder(
            $template['text'],
            $actions
        );
        return new TemplateMessageBuilder($altText, $buttons, $quickReply);
    }

    /**
     * build carousel template
     *
     * @param string $altText
     * @param array $template
     * @return TemplateMessageBuilder
     * @throws MessageBuilderException
     */
    protected function buildCarouselMessage(string $altText, array $template): TemplateMessageBuilder
    {
        $this->validate(
            $template,
            [
                'columns' => 'required|array|max:10',
                'columns.*.text' => 'required|string|max:120',
                'columns.*.actions' => 'required|array|max:3',
            ]
        );

        $columns = [];
        foreach ($template['columns'] as $column) {
            $text = $column['text'];
            $actions = [];
            foreach ($column['actions'] as $action) {
                array_push($actions, $this->getAction($action));
            }

            $title = $column['title'] ?? null;
            $image = $column['thumbnailImageUrl'] ?? null;
            $imageBackgroundColor = $columns['imageBackgroundColor'] ?? null;

            array_push(
                $columns,
                new CarouselColumnTemplateBuilder(
                    $title,
                    $text,
                    $image,
                    $actions,
                    $imageBackgroundColor
                )
            );
        }
        $template['imageAspectRatio'] = $template['imageAspectRatio'] ?? null;
        $template['imageSize'] = $template['imageSize'] ?? null;

        $quickReply = $this->buildQuickReply($template);

        $carousel = new CarouselTemplateBuilder($columns, $template['imageAspectRatio'], $template['imageSize']);
        return new TemplateMessageBuilder($altText, $carousel, $quickReply);
    }

    /**
     * @throws MessageBuilderException
     */
    protected function buildImageCarouselMessage(string $altText, array $template): TemplateMessageBuilder
    {
        $this->validate(
            $template,
            [
                'columns' => 'required|array|max:10',
                'columns.*.imageUrl' => 'required',
                'columns.*.action' => 'required|array',
            ]
        );
        $columns = [];
        foreach ($template['columns'] as $column) {
            $imageUri = $column['imageUrl'];
            $action = $this->getAction($column['action'], true);

            array_push($columns, new ImageCarouselColumnTemplateBuilder($imageUri, $action));
        }

        $quickReply = $this->buildQuickReply($template);

        $imageCarousel = new ImageCarouselTemplateBuilder($columns);
        return new TemplateMessageBuilder($altText, $imageCarousel, $quickReply);
    }

    /**
     * @throws MessageBuilderException
     */
    protected function buildImageMapMessage(string $altText, array $template): ImagemapMessageBuilder
    {
        $this->validate(
            $template,
            [
                'baseUrl' => 'required|max:1000',
                'baseSize.width' => 'required|integer',
                'baseSize.height' => 'required|integer',
                'actions' => 'required|array|max:50',
                'actions.*.type' => 'required|in:uri,message',
                'actions.*.area' => 'required|array',
                'actions.*.text' => 'required_if:actions.*.type,message',
                'actions.*.linkUri' => 'required_if:actions.*.type,uri',
                'actions.*.area.*' => 'required|integer',
            ]
        );

        $baseUrl = $template['baseUrl'];
        $baseSize = $this->getImageMapBaseSize($template['baseSize']);

        $videoBuilder = (isset($template['video']))
            ? $this->getImageMapVideoBuilder($template['video'])
            : null;

        $actions = [];
        foreach ($template['actions'] as $action) {
            array_push($actions, $this->getImageMapAction($action));
        }

        $quickReply = $this->buildQuickReply($template);

        return new ImagemapMessageBuilder(
            $baseUrl,
            $altText,
            $baseSize,
            $actions,
            $quickReply,
            $videoBuilder
        );
    }

    /**
     * @throws MessageBuilderException
     */
    protected function buildAudioMessage(array $template): AudioMessageBuilder
    {
        $this->validate($template, ['originalContentUrl' => 'required', 'duration' => 'required|numeric']);
        $quickReply = $this->buildQuickReply($template);
        return new AudioMessageBuilder($template['originalContentUrl'], $template['duration'], $quickReply);
    }

    /**
     * @throws MessageBuilderException
     */
    protected function buildVideoMessage(array $template): VideoMessageBuilder
    {
        $this->validate($template, ['originalContentUrl' => 'required', 'previewImageUrl' => 'required']);
        $quickReply = $this->buildQuickReply($template);
        return new VideoMessageBuilder($template['originalContentUrl'], $template['previewImageUrl'], $quickReply);
    }

    /**
     * @throws MessageBuilderException
     */
    protected function buildImageMessage(array $template): ImageMessageBuilder
    {
        $this->validate($template, ['originalContentUrl' => 'required', 'previewImageUrl' => 'required']);
        $quickReply = $this->buildQuickReply($template);
        return new ImageMessageBuilder($template['originalContentUrl'], $template['previewImageUrl'], $quickReply);
    }

    /**
     * @throws MessageBuilderException
     */
    protected function buildStickerMessage(array $template): StickerMessageBuilder
    {
        $this->validate($template, ['packageId' => 'required|integer', 'stickerId' => 'required|integer']);
        $quickReply = $this->buildQuickReply($template);
        return new StickerMessageBuilder($template['packageId'], $template['stickerId'], $quickReply);
    }

    /**
     * @throws MessageBuilderException
     */
    protected function buildLocationMessage(array $template): LocationMessageBuilder
    {
        $this->validate(
            $template,
            [
                'title' => 'required|max:100',
                'address' => 'required|max:100',
                'lat' => 'required|numeric',
                'lon' => 'required|numeric',
            ]
        );
        $quickReply = $this->buildQuickReply($template);
        return new LocationMessageBuilder(
            $template['title'],
            $template['address'],
            $template['lat'],
            $template['lon'],
            $quickReply
        );
    }

    /**
     * @throws MessageBuilderException
     */
    protected function buildTextMessage(array $template): TextMessageBuilder
    {
        $this->validate($template, ['text' => 'required|max:2000']);
        $quickReply = $this->buildQuickReply($template);
        return new TextMessageBuilder($template['text'], $quickReply);
    }

    /**
     * @throws MessageBuilderException
     */
    protected function buildMultiMessage(string $altText, array $messageList): MultiMessageBuilder
    {
        if (count($messageList) > self::MULTI_MESSAGE_LIMIT) {
            throw new MessageBuilderException('You can only combine ' .
                self::MULTI_MESSAGE_LIMIT .
                ' messages at a time');
        }
        $builder = new MultiMessageBuilder();

        $generalTypes = GeneralMessageType::getConstants();
        $templateTypes = TemplateMessageType::getConstants();
        $allMessageTypes = $generalTypes + $templateTypes;

        foreach ($messageList as $message) {
            $type = $message['type'];
            if (!in_array($type, $allMessageTypes)) {
                throw new MessageBuilderException('Invalid message type');
            }
            if (in_array($type, $generalTypes)) {
                $builder->add(
                    call_user_func(
                        [$this, 'build' . ucfirst(Str::camel($type)) . 'Message'],
                        $message
                    )
                );
            } elseif (in_array($type, $templateTypes)) {
                if ($type === TemplateMessageType::FLEX) {
                    $message = $message['contents'];
                }
                $builder->add(
                    call_user_func(
                        [$this, 'build' . ucfirst(Str::camel($type)) . 'Message'],
                        $altText,
                        $message
                    )
                );
            }
        }
        return $builder;
    }

    /**
     * @throws MessageBuilderException
     */
    protected function buildFlexMessage(string $altText, array $template): FlexMessageBuilder
    {
        $boxValidationRule = [];

        $types = FlexBoxElement::getConstants();

        foreach ($types as $type) {
            $boxValidationRule[$type] = 'nullable|array';
            if ($type === 'hero') {
                $boxValidationRule[$type . '.url'] = 'required_if:hero.type,image';
                $boxValidationRule[$type . '.contents'] = 'required_if:hero.type,box|array';
                $boxValidationRule[$type . '.contents.*.action'] = 'nullable|array';
                continue;
            }
            $boxValidationRule[$type . '.layout'] = 'sometimes|required';
            $boxValidationRule[$type . '.contents'] = 'sometimes|required|array';
            $boxValidationRule[$type . '.contents.*.action'] = 'nullable|array';
        }

        $this->validate(
            $template,
            [
                'type' => 'required|in:bubble,carousel',
                'styles' => 'nullable|array',
                'contents' => 'required_if:type,carousel|array|max:10',
                'contents.*.styles' => 'nullable|array',
            ] + $boxValidationRule
        );

        $flex = new LINEFlexContainerBuilder($template['type']);
        $flex->createComponents($template);

        $container = $flex->getContainer();
        $quickReply = $this->buildQuickReply($template);

        return new FlexMessageBuilder($altText, $container, $quickReply);
    }
}
