<?php

namespace Whchi\LaravelLineBotWrapper\Traits;

use LINE\LINEBot\MessageBuilder;
use Whchi\LaravelLineBotWrapper\Exceptions\MessageBuilderException;

trait MessagePusher
{
    /**
     * @throws MessageBuilderException
     */
    public function pushButton(string $altText, array $template): void
    {
        $message = $this->buildButtonMessage($altText, $template);
        $this->pushMessage($message);
    }

    /**
     * @throws MessageBuilderException
     */
    public function pushConfirm(string $altText, array $template): void
    {
        $message = $this->buildConfirmMessage($altText, $template);
        $this->pushMessage($message);
    }

    /**
     * @throws MessageBuilderException
     */
    public function pushCarousel(string $altText, array $template): void
    {
        $message = $this->buildCarouselMessage($altText, $template);
        $this->pushMessage($message);
    }

    /**
     * @throws MessageBuilderException
     */
    public function pushImageCarousel(string $altText, array $template): void
    {
        $message = $this->buildImageCarouselMessage($altText, $template);
        $this->pushMessage($message);
    }

    /**
     * @throws MessageBuilderException
     */
    public function pushAudio(array $template): void
    {
        $audio = $this->buildAudioMessage($template);
        $this->pushMessage($audio);
    }

    /**
     * @throws MessageBuilderException
     */
    public function pushVideo(array $template): void
    {
        $message = $this->buildVideoMessage($template);
        $this->pushMessage($message);
    }

    /**
     * @throws MessageBuilderException
     */
    public function pushImage(array $template): void
    {
        $message = $this->buildImageMessage($template);
        $this->pushMessage($message);
    }

    /**
     * @throws MessageBuilderException
     */
    public function pushImageMap(string $altText, array $imageMap): void
    {
        $message = $this->buildImageMapMessage($altText, $imageMap);

        $this->pushMessage($message);
    }

    /**
     * @throws MessageBuilderException
     */
    public function pushSticker(array $template): void
    {
        $message = $this->buildStickerMessage($template);
        $this->pushMessage($message);
    }

    /**
     * @throws MessageBuilderException
     */
    public function pushLocation(array $template): void
    {
        $message = $this->buildLocationMessage($template);
        $this->pushMessage($message);
    }

    /**
     * @throws MessageBuilderException
     */
    public function pushText(array $template): void
    {
        $message = $this->buildTextMessage($template);
        $this->pushMessage($message);
    }

    /**
     * push multi message
     *
     * @param string $altText
     * @param array $templateList
     * @return void
     * @throws MessageBuilderException
     */
    public function push(string $altText, array $templateList): void
    {
        $message = $this->buildMultiMessage($altText, $templateList);
        $this->pushMessage($message);
    }

    /**
     * push to multiple users at a time
     *
     * @param array $userIdList
     * @param string $altText
     * @param array $templateList
     * @return void
     * @throws MessageBuilderException
     */
    public function pushMulticast(array $userIdList, string $altText, array $templateList): void
    {
        $message = $this->buildMultiMessage($altText, $templateList);
        $response = $this->bot->multicast($userIdList, $message);
        if (!$response->isSucceeded()) {
            throw new MessageBuilderException($response->getHTTPStatus() . PHP_EOL . $response->getRawBody());
        }
    }

    /**
     * Flex message
     *
     * @param string $altText
     * @param array $flexTemplate
     * @return void
     * @throws MessageBuilderException
     */
    public function pushFlex(string $altText, array $flexTemplate): void
    {
        $message = $this->buildFlexMessage($altText, $flexTemplate);
        $this->pushMessage($message);
    }

    /**
     * @throws MessageBuilderException
     */
    private function pushMessage(MessageBuilder $message)
    {
        $response = $this->bot->pushMessage($this->pushTo, $message);
        if (!$response->isSucceeded()) {
            throw new MessageBuilderException($response->getHTTPStatus() . PHP_EOL . $response->getRawBody());
        }
    }
}
