<?php

namespace Whchi\LaravelLineBotWrapper\Core\MessageBuilders\FlexMessageBuilder;

use Illuminate\Support\Collection;
use LINE\LINEBot\Constant\Flex\ContainerType;
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;
use LINE\LINEBot\MessageBuilder\Flex\BubbleStylesBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ImageComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\BubbleContainerBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\CarouselContainerBuilder;
use Whchi\LaravelLineBotWrapper\Exceptions\MessageBuilderException;

class LINEFlexMessageBuilder
{
    /**
     * Flex message container
     *
     * @var BubbleContainerBuilder
     */
    private $bubbleContainer;

    /**
     * Flex message container
     *
     * @var CarouselContainerBuilder
     */
    private $carouselContainer;

    private $templateType;

    public function __construct(string $templateType)
    {
        $this->templateType = $this->setTemplateType($templateType);
    }

    public function getContainer(): ContainerBuilder
    {
        if ($this->templateType === ContainerType::CAROUSEL) {
            return $this->carouselContainer;
        }
        return $this->bubbleContainer;
    }

    public function createComponents(array $template)
    {
        switch ($this->templateType) {
            case ContainerType::BUBBLE:
                return $this->setBubbleTemplate($template);
            case ContainerType::CAROUSEL:
                return $this->setCarouselTemplate($template);
        }
    }

    private function setTemplateType(string $type)
    {
        if (!in_array($type, [ContainerType::BUBBLE, ContainerType::CAROUSEL])) {
            throw new MessageBuilderException('Invalid container type');
        }
        return $type;
    }

    private function setBubbleTemplate(array $template): BubbleContainerBuilder
    {
        // avoid invalid key error
        if (isset($template['type'])) {
            unset($template['type']);
        }

        $this->bubbleContainer = BubbleContainerBuilder::builder();
        foreach ($template as $idx => $ele) {
            switch ($idx) {
                case 'header':
                    $this->bubbleContainer->setHeader($this->createBubbleHeader($ele));
                    break;
                case 'hero':
                    $this->bubbleContainer->setHero($this->createBubbleHero($ele));
                    break;
                case 'body':
                    $this->bubbleContainer->setBody($this->createBubbleBody($ele));
                    break;
                case 'footer':
                    $this->bubbleContainer->setFooter($this->createBubbleFooter($ele));
                    break;
                case 'styles':
                    $this->bubbleContainer->setStyles($this->createBubbleStyle($ele));
                    break;
                case 'direction':
                    $this->bubbleContainer->setDirection($ele);
                    break;
                default:
                    throw new MessageBuilderException('Invalid key in flex-bubble template');
                    break;
            }
        }

        return $this->bubbleContainer;
    }

    private function setCarouselTemplate(array $template): CarouselContainerBuilder
    {
        $this->carouselContainer = CarouselContainerBuilder::builder();

        if ($template['contents']->count() > 10) {
            throw new MessageBuilderException('Maximum size of flex carousel exceed');
        }
        $carousel = $template['contents']->map(function ($ele, $idx) {
            return $this->setBubbleTemplate($ele);
        })->toArray();
        $this->carouselContainer->setContents($carousel);
        return $this->carouselContainer;
    }

    private function createBubbleHeader(array $blockTemplate): BoxComponentBuilder
    {
        return LINEFlexComponentBuilder::setComponentTemplate($blockTemplate);
    }

    private function createBubbleHero(array $blockTemplate): ImageComponentBuilder
    {
        return LINEFlexComponentBuilder::setComponentTemplate($blockTemplate);
    }

    private function createBubbleBody(array $blockTemplate)
    {
        return LINEFlexComponentBuilder::setComponentTemplate($blockTemplate);
    }

    private function createBubbleFooter(array $blockTemplate): BoxComponentBuilder
    {
        return LINEFlexComponentBuilder::setComponentTemplate($blockTemplate);
    }

    private function createBubbleStyle(Collection $styles): BubbleStylesBuilder
    {
        return LINEFlexComponentBuilder::setComponentStyle($styles);
    }
}
