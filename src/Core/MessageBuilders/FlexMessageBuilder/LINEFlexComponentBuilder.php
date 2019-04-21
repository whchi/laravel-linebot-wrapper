<?php

namespace Whchi\LaravelLineBotWrapper\Core\MessageBuilders\FlexMessageBuilder;

use Illuminate\Support\Collection;
use LINE\LINEBot\Constant\Flex\ComponentType;
use LINE\LINEBot\MessageBuilder\Flex\BlockStyleBuilder;
use LINE\LINEBot\MessageBuilder\Flex\BubbleStylesBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder as BoxLayout;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ButtonComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\FillerComponentBuilder as FillerLayout;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\IconComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ImageComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\SeparatorComponentBuilder as SeparatorLayout;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\SpacerComponentBuilder as SpacerLayout;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder;
use Whchi\LaravelLineBotWrapper\Core\MessageBuilders\Helpers\LINETemplateActionBuilder;
use Whchi\LaravelLineBotWrapper\Exceptions\MessageBuilderException;

class LINEFlexComponentBuilder
{
    /**
     * @var BubbleStylesBuilder
     */
    public static $templateStyle;

    /**
     * @var LINEFlexComponentBuilder
     */
    private static $instance = null;

    /**
     * Flex message block style
     */
    private static $blockStyle;

    public static function getInstance()
    {
        if (self::$instance) {
            return self::$instace;
        }
        return new LINEFlexComponentBuilder;
    }

    public static function setComponentTemplate(array $blockTemplate): ComponentBuilder
    {
        // avoid invalid key error
        $type = $blockTemplate['type'];
        unset($blockTemplate['type']);

        switch ($type) {
            case ComponentType::TEXT:
                return self::setText($blockTemplate);
            case ComponentType::IMAGE:
                return self::setImage($blockTemplate);
            case ComponentType::BUTTON:
                return self::setButton($blockTemplate);
            case ComponentType::ICON:
                return self::setIcon($blockTemplate);
            case ComponentType::BOX:
                return self::setBoxLayout($blockTemplate);
            case ComponentType::FILLER:
                return self::setFillerLayout($blockTemplate);
            case ComponentType::SEPARATOR:
                return self::setSeparatorLayout($blockTemplate);
            case ComponentType::SPACER:
                return self::setSpacerLayout($blockTemplate);
            default:
                throw new MessageBuilderException('Invalid component type');
        }
    }

    /**
     * Flex message component block style
     * @see https://developers.line.biz/en/reference/messaging-api/#style-setting-objects
     *
     * @param Collection $styles
     * @return BubbleStylesBuilder
     */
    public static function setComponentStyle(Collection $styles): BubbleStylesBuilder
    {
        $bubbleStyles = $styles->map(function ($style) {
            $blockStyle = BlockStyleBuilder::builder();
            foreach ($style as $k => $v) {
                if (!in_array($k, ['backgroundColor', 'separator', 'separatorColor'])) {
                    throw new MessageBuilderException('Invalid block style');
                }
                call_user_func([$blockStyle, 'set' . ucfirst($k)], $v);
            }
            return $blockStyle;
        });

        $builder = BubbleStylesBuilder::builder();
        $bubbleStyles->map(function ($ele, $idx) use ($builder) {
            if (!in_array($idx, ['header', 'hero', 'body', 'footer'])) {
                throw new MessageBuilderException('Invalid block style');
            }
            call_user_func([$builder, 'set' . ucfirst($idx)], $ele);
        });

        return $builder;
    }
    /**
     * Flex message component type "text"
     * @see https://developers.line.biz/en/reference/messaging-api/#f-text
     *
     * @param array $template
     * @return TextComponentBuilder
     */
    private static function setText(array $template): TextComponentBuilder
    {
        $builder = TextComponentBuilder::builder()->setText($template['text']);
        unset($template['text']);

        foreach ($template as $idx => $ele) {
            if (!in_array($idx, ['flex', 'margin', 'size', 'align', 'gravity', 'maxLines', 'weight', 'color', 'action', 'wrap'])) {
                throw new MessageBuilderException('Invalid TextComponent type: ' . $idx);
            }
            if ($idx === 'action') {
                $action = LINETemplateActionBuilder::getAction($ele);
                $builder->setAction($action);
            } else {
                call_user_func([$builder, 'set' . ucfirst($idx)], $ele);
            }
        }

        return $builder;
    }

    /**
     * Flex message component type "image"
     * @see https://developers.line.biz/en/reference/messaging-api/#f-image
     *
     * @param array $template
     * @return ImageComponentBuilder
     */
    private static function setImage(array $template): ImageComponentBuilder
    {
        $builder = ImageComponentBuilder::builder()->setUrl($template['url']);
        unset($template['url']);

        foreach ($template as $idx => $ele) {
            if (!in_array($idx, ['flex', 'margin', 'size', 'align', 'gravity', 'aspectRatio', 'aspectMode', 'backgroundColor', 'action'])) {
                throw new MessageBuilderException('Invalid ImageComponent type: ' . $idx);
            }
            if ($idx === 'action') {
                $action = LINETemplateActionBuilder::getAction($ele);
                $builder->setAction($action);
            } else {
                call_user_func([$builder, 'set' . ucfirst($idx)], $ele);
            }
        }
        return $builder;
    }

    // layout components below

    /**
     * Flex message component type "button"
     * @see https://developers.line.biz/en/reference/messaging-api/#button
     *
     * @param array $template
     * @return ButtonComponentBuilder
     */
    private static function setButton(array $template): ButtonComponentBuilder
    {
        $builder = ButtonComponentBuilder::builder();
        $action = LINETemplateActionBuilder::getAction($template['action']);
        unset($template['action']);
        $builder->setAction($action);

        foreach ($template as $idx => $ele) {
            if (!in_array($idx, ['flex', 'margin', 'height', 'style', 'color', 'gravity'])) {
                throw new MessageBuilderException('Invalid ImageComponent type: ' . $idx);
            }
            call_user_func([$builder, 'set' . ucfirst($idx)], $ele);
        }
        return $builder;
    }

    /**
     * Flex message component type "icon", use only with box.layout = "baseline"
     * @see https://developers.line.biz/en/reference/messaging-api/#icon
     *
     * @param array $template
     * @return IconComponentBuilder
     */
    private static function setIcon(array $template): IconComponentBuilder
    {
        $builder = IconComponentBuilder::builder()->setUrl($template['url']);
        unset($template['url']);

        foreach ($template as $idx => $ele) {
            if (!in_array($idx, ['margin', 'size', 'aspectRatio'])) {
                throw new MessageBuilderException('Invalid ImageComponent type: ' . $idx);
            }
            call_user_func([$builder, 'set' . ucfirst($idx)], $ele);
        }
        return $builder;
    }

    /**
     * Flex message component type "box"
     * only box component has "contents"
     * @see https://developers.line.biz/en/reference/messaging-api/#box
     *
     * @param Collection $template
     * @return BoxLayout
     */
    private static function setBoxLayout(array $template): BoxLayout
    {
        $builder = BoxLayout::builder()->setLayout($template['layout']);

        $contents = $template['contents']->map(function ($ele, $idx) {
            return self::setComponentTemplate($ele);
        })->toArray();

        $builder->setContents($contents);

        unset($template['layout'], $template['contents']);

        foreach ($template as $idx => $ele) {
            if (!in_array($idx, ['flex', 'spacing', 'margin', 'action'])) {
                throw new MessageBuilderException('Invalid BoxLayout type: ' . $idx);
            }
            if ($idx === 'action') {
                $action = LINETemplateActionBuilder::getAction($ele);
                $builder->setAction($action);
            } else {
                call_user_func([$builder, 'set' . ucfirst($idx)], $ele);
            }
        }

        return $builder;
    }
    /**
     * Flex message component type "filler"
     * @see https://developers.line.biz/en/reference/messaging-api/#filler
     *
     * @param array $template
     * @return FillerLayout
     */
    private static function setFillerLayout(array $template): FillerLayout
    {
        $builder = FillerLayout::builder();
        return $builder;
    }

    /**
     * Flex message component type "separator"
     * @see https://developers.line.biz/en/reference/messaging-api/#separator
     *
     * @param array $template
     * @return SeparatorLayout
     */
    private static function setSeparatorLayout(array $template): SeparatorLayout
    {
        $builder = SeparatorLayout::builder();

        foreach ($template as $idx => $ele) {
            if (!in_array($idx, ['margin', 'color'])) {
                throw new MessageBuilderException('Invalid SeparatorLayout type: ' . $idx);
            }
            call_user_func([$builder, 'set' . ucfirst($idx)], $ele);
        }
        return $builder;
    }

    /**
     * Flex message component type "spacer"
     * @see https://developers.line.biz/en/reference/messaging-api/#spacer
     *
     * @param array $template
     * @return SpacerLayout
     */
    private static function setSpacerLayout(array $template): SpacerLayout
    {
        $builder = SpacerLayout::builder();
        if (isset($template['size'])) {
            $builder->setSize($template['size']);
        }
        return $builder;
    }
}
