<?php

namespace Whchi\LaravelLineBotWrapper\Core;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use Whchi\LaravelLineBotWrapper\Exceptions\BotStateException;

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
     * session id
     *
     * @var string
     */
    protected $botSessionId;

    /**
     * linecorp/line-php-sdk http client
     *
     * @var CurlHTTPClient
     */
    protected $httpClient;
    /**
     * available variable name
     *
     * @var array
     */
    private $whiteList;

    public function __construct()
    {
        $this->httpClient = new CurlHTTPClient(config('linebot.channelAccessToken'));
        $this->bot = new LINEBot(
            $this->httpClient,
            ['channelSecret' => config('linebot.channelSecret')]
        );
        $this->whiteList = ['eventType', 'messageEventType', 'rawEvent', 'userId', 'botSessionId'];
    }

    public function setContext($event)
    {
        $this->replyToken = $event['replyToken'];
        $this->eventType = $event['type'];
        $this->sourceType = $event['source']['type'];
        $this->userId = $event['source']['userId'];
        $this->groupId = ($event['source']['type'] === 'group')
        ? $event['source']['groupId'] : null;
        $this->roomId = ($event['source']['type'] === 'room')
        ? $event['source']['roomId'] : null;
        $this->botSessionId = $this->groupId ?? $this->roomId ?? $this->userId;
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
        if (in_array($name, $this->whiteList)) {
            return $this->{$name};
        }
        throw new BotStateException('Trying to get non-accessable variable "' . $name . '"');
    }
}
