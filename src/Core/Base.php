<?php

namespace Whchi\LaravelLineBotWrapper\Core;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use Log;

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

    /**
     * available variable name
     *
     * @var array
     */
    private $whiteList;
    /**
     * linecorp/line-php-sdk http client
     *
     * @var CurlHTTPClient
     */
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new CurlHTTPClient(config('linebot.channelAccessToken'));
        $this->bot = new LINEBot(
            $this->httpClient,
            ['channelSecret' => config('linebot.channelSecret')]
        );
        $this->whiteList = ['eventType', 'messageEventType', 'rawEvent'];
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

    /**
     * read only variables
     *
     * @param string $name
     */
    public function __get(string $name)
    {
        if (array_key_exists($name, $this->whiteList)) {
            return $this->name;
        }
        Log::error('Trying to get non-accessable variable "' . $name . '"');
        return null;
    }
}
