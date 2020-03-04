<?php

namespace Whchi\LaravelLineBotWrapper\Traits;

use LINE\LINEBot\MessageBuilder;
use Whchi\LaravelLineBotWrapper\Exceptions\MessageBuilderException;

trait MessageReplier
{
    public function replyButton(string $altText, array $template): void
    {
        $message = $this->buildButtonMessage($altText, $template);
        $this->replyMessage($message);
    }

    public function replyConfirm(string $altText, array $template): void
    {
        $message = $this->buildConfirmMessage($altText, $template);
        $this->replyMessage($message);
    }

    public function replyCarousel(string $altText, array $template): void
    {
        $message = $this->buildCarouselMessage($altText, $template);
        $this->replyMessage($message);
    }

    public function replyImageCarousel(string $altText, array $template): void
    {
        $message = $this->buildImageCarouselMessage($altText, $template);
        $this->replyMessage($message);
    }

    public function replyAudio(array $template): void
    {
        $audio = $this->buildAudioMessage($template);
        $this->replyMessage($audio);
    }

    public function replyVideo(array $template): void
    {
        $message = $this->buildVideoMessage($template);
        $this->replyMessage($message);
    }

    public function replyImage(array $template): void
    {
        $message = $this->buildImageMessage($template);
        $this->replyMessage($message);
    }

    public function replyImageMap(string $altText, array $imageMap): void
    {
        $message = $this->buildImageMapMessage($altText, $imageMap);
        $this->replyMessage($message);
    }

    public function replySticker(array $template): void
    {
        $message = $this->buildStickerMessage($template);
        $this->replyMessage($message);
    }

    public function replyLocation(array $template): void
    {
        $message = $this->buildLocationMessage($template);
        $this->replyMessage($message);
    }

    public function replyText(array $template): void
    {
        $message = $this->buildTextMessage($template);
        $this->replyMessage($message);
    }

    /**
     * reply multi message
     *
     * @param  array $messages
     * @return void
     */
    public function reply(string $altText, array $templateList): void
    {
        $message = $this->buildMultiMessage($altText, $templateList);
        $this->replyMessage($message);
    }

    /**
     * Flex message
     *
     * @return void
     */
    public function replyFlex(string $altText, array $flexTemplate): void
    {
        $message = $this->buildFlexMessage($altText, $flexTemplate);
        $this->replyMessage($message);
    }

    private function replyMessage(MessageBuilder $message)
    {
        $response = $this->bot->replyMessage($this->replyToken, $message);
        if (!$response->isSucceeded()) {
            throw new MessageBuilderException($response->getHTTPStatus() . PHP_EOL . $response->getRawBody());
        }
    }
}
