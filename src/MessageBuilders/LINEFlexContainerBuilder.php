<?php

namespace Whchi\LaravelLineBotWrapper\MessageBuilders;

use LINE\LINEBot\Constant\Flex\ContainerType;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\BubbleContainerBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\CarouselContainerBuilder;
use Whchi\LaravelLineBotWrapper\Constant\FlexBoxElement;
use Whchi\LaravelLineBotWrapper\Exceptions\MessageBuilderException;

class LINEFlexContainerBuilder
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

    private $componentBuilder;
    private $templateType;

    public function __construct(string $templateType)
    {
        $this->setTemplateType($templateType);
        $this->componentBuilder = new LINEFlexComponentBuilder;
    }

    public function getContainer(): ContainerBuilder
    {
        if ($this->templateType === ContainerType::CAROUSEL) {
            return $this->carouselContainer;
        }
        return $this->bubbleContainer;
    }

    /**
     * @param array $template
     * @return BubbleContainerBuilder|CarouselContainerBuilder
     * @throws MessageBuilderException
     * @throws \ReflectionException
     */
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
        $this->templateType = $type;
    }

    /**
     * @throws MessageBuilderException|\ReflectionException
     */
    private function setBubbleTemplate(array $template): BubbleContainerBuilder
    {
        // avoid invalid key error
        unset($template['type'], $template['quickReply']);

        $this->bubbleContainer = BubbleContainerBuilder::builder();
        $flexTypes = FlexBoxElement::getConstants();
        foreach ($template as $idx => $ele) {
            if (in_array($idx, $flexTypes)) {
                call_user_func(
                    [$this->bubbleContainer, 'set' . ucfirst($idx)],
                    $this->componentBuilder->setComponentTemplate($ele)
                );
            } else {
                switch ($idx) {
                    case 'styles':
                        $this->bubbleContainer->setStyles($this->componentBuilder->setComponentStyle($ele));
                        break;
                    case 'direction':
                        $this->bubbleContainer->setDirection($ele);
                        break;
                    default:
                        throw new MessageBuilderException('Invalid key in flex-bubble template');
                }
            }
        }

        return $this->bubbleContainer;
    }

    /**
     * @param array $template
     * @return CarouselContainerBuilder
     * @throws MessageBuilderException
     * @throws \ReflectionException
     */
    private function setCarouselTemplate(array $template): CarouselContainerBuilder
    {
        $this->carouselContainer = CarouselContainerBuilder::builder();

        $carousels = [];
        foreach ($template['contents'] as $content) {
            array_push($carousels, $this->setBubbleTemplate($content));
        }

        $this->carouselContainer->setContents($carousels);
        return $this->carouselContainer;
    }
}
