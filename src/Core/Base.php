<?php

namespace Whchi\LaravelLineBotWrapper\Core;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class Base
{
    /**
     * LINE sdk instance
     *
     * @var LINEBot
     */
    protected $bot;

    /**
     * reply message token
     *
     * @var string
     */
    protected $replyToken;
    /**
     * event.source
     *
     * @var string nullable
     */
    protected $userId;
    protected $groupId;
    protected $roomId;

    /**
     * event.source.type
     *
     * @var string group | room | user
     */
    protected $sourceType;
    /**
     * event.type
     *
     * @var string
     * @see https://developers.line.biz/en/reference/messaging-api/#common-properties
     */
    protected $eventType;

    /**
     * event.message.type
     *
     * @var string
     */
    protected $messageEventType;
    /**
     * LINE raw event
     *
     * @var array
     */
    protected $rawEvent;
    /**
     * session state key
     *
     * @var string
     */
    protected $sessionStateCacheKey;

    public function __construct()
    {
        $this->bot = new LINEBot(
            new CurlHTTPClient(config('linebot.channelAccessToken')),
            ['channelSecret' => config('linebot.channelSecret')]
        );
    }

    public function setContext($event)
    {
        $this->replyToken = $event['replyToken'];
        $this->eventType = $event['type'];
        $this->sourceType = $event['source']['type'];
        $this->userId = $event['source']['userId'] ?? null;
        $this->groupId = $event['source']['groupId'] ?? null;
        $this->roomId = $event['source']['userId'] ?? null;
        $this->sessionStateCacheKey = $this->groupId ?? $this->roomId ?? $this->userId;
        $this->messageEventType = ($this->eventType === 'message') ? $event['message']['type'] : null;
        $this->rawEvent = $event;
    }
}
