<?php

namespace Whchi\LaravelLineBotWrapper;

use LINE\LINEBot as BaseBot;
use Whchi\LaravelLineBotWrapper\MessageBuilders\LINEMessageBuilder;
use Whchi\LaravelLineBotWrapper\Exceptions\BotStateException;
use Whchi\LaravelLineBotWrapper\Traits\BotState;
use Whchi\LaravelLineBotWrapper\Traits\Context;
use Whchi\LaravelLineBotWrapper\Traits\MessagePusher;
use Whchi\LaravelLineBotWrapper\Traits\MessageReplier;

class LINEBotContext extends LINEMessageBuilder
{
    use BotState;
    use Context;
    use MessageReplier;
    use MessagePusher;

    protected $bot;
    protected $replyToken;
    protected $userId;
    protected $groupId;
    protected $roomId;
    protected $sourceType;
    protected $eventType;
    protected $messageEventType;
    protected $rawEvent;
    protected $botSessionId;
    protected $httpClient;

    private $whiteList;

    /**
     * LINEBotContext constructor.
     * @param BaseBot $bot
     */
    public function __construct(BaseBot $bot)
    {
        $this->bot = $bot;
        $this->whiteList = ['eventType', 'messageEventType', 'rawEvent', 'userId', 'botSessionId'];
    }

    public function setContext($event)
    {
        $this->replyToken = $event['replyToken'] ?? null;
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
     * @return mixed
     * @throws BotStateException
     */
    public function __get(string $name)
    {
        if (!in_array($name, $this->whiteList)) {
            throw new BotStateException('Trying to get non-accessible variable "' . $name . '"');
        }
        return $this->{$name};
    }

    public function sdk(string $fn, array $arguments)
    {
        return call_user_func_array([$this->bot, $fn], $arguments);
    }
}
