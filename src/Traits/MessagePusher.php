<?php

namespace Whchi\LaravelLineBotWrapper\Traits;

use LINE\LINEBot\MessageBuilder;
use Log;

trait MessagePusher
{
    public function pushButtonTemplate(string $altText, array $template): void
    {
        $message = $this->buildButtonTemplateMessage($altText, $template);
        $this->pushMessage($message);
    }

    public function pushConfirmTemplate(string $altText, array $template): void
    {
        $message = $this->buildConfirmTemplateMessage($altText, $template);
        $this->pushMessage($message);
    }

    public function pushCarouselTemplate(string $altText, array $template): void
    {
        $message = $this->buildCarouselTemplateMessage($altText, $template);
        $this->pushMessage($message);
    }

    public function pushImageCarouselTemplate(string $altText, array $template): void
    {
        $message = $this->buildImageCarouselTemplateMessage($altText, $template);
        $this->pushMessage($message);
    }

    public function pushAudio(array $template): void
    {
        $audio = $this->buildAudioMessage($template);
        $this->pushMessage($audio);
    }

    public function pushVideo(array $template): void
    {
        $message = $this->buildVideoMessage($template);
        $this->pushMessage($message);
    }

    public function pushImage(array $template): void
    {
        $message = $this->buildImageMessage($template);
        $this->pushMessage($message);
    }

    public function pushImageMap(string $altText, array $imageMap): void
    {
        $message = $this->buildImageMapMessage($altText, $imageMap);

        $this->pushMessage($message);
    }

    public function pushSticker(array $template): void
    {
        $message = $this->buildStickerMessage($template);
        $this->pushMessage($message);
    }

    public function pushLocation(array $template): void
    {
        $message = $this->buildLocationMessage($template);
        $this->pushMessage($message);
    }

    public function pushText(array $template): void
    {
        $message = $this->buildTextMessage($template);
        $this->pushMessage($message);
    }

    /**
     * push multi message
     *
     * @param array $messages
     * @return void
     */
    public function push(string $altText, array $messageList): void
    {
        $message = $this->buildMultiMessages($altText, $messageList);
        $this->pushMessage($message);
    }

    /**
     * push to multiple users at a time
     *
     * @param array $userIdList
     * @param string $altText
     * @param array $template
     * @return void
     */
    public function pushMulticast(array $userIdList, string $altText, array $messageList): void
    {
        $message = $this->buildMultiMessages($altText, $messageList);
        $response = $this->bot->multicast($userIdList, $template);
        if(!$response->isSucceeded()) {
            Log::debug($response->getHTTPStatus() . PHP_EOL . $response->getRawBody());
        }
    }

    /**
     * Flex message
     *
     * @return void
     */
    public function pushFlex(string $altText, array $flexTemplate): void
    {
        $message = $this->buildFlexMessage($altText, $flexTemplate);
        $this->pushMessage($message);
    }

    private function pushMessage(MessageBuilder $message)
    {
        $response = $this->bot->pushMessage($this->pushTo, $message);
        if (!$response->isSucceeded()) {
            Log::debug($response->getHTTPStatus() . PHP_EOL . $response->getRawBody());
        }
    }
}
