<?php

namespace Whchi\LaravelLineBotWrapper;

use Log;
use Whchi\LaravelLineBotWrapper\Core\MessageBuilders\LINEMessageBuilder;
use Whchi\LaravelLineBotWrapper\Traits\BotState;
use Whchi\LaravelLineBotWrapper\Traits\MessagePusher;
use Whchi\LaravelLineBotWrapper\Traits\MessageReplier;

class LINEBotContext extends LINEMessageBuilder
{
    use MessageReplier, MessagePusher, BotState;

    protected $pushTo;

    public function setPushTo(string $memberId)
    {
        $this->pushTo = $memberId;
    }

    public function getMessagePayload()
    {
        return $this->isMessageEvent() ? $this->rawEvent['message'] : null;
    }

    public function getPostbackPayload()
    {
        return $this->isPostBackEvent() ? $this->rawEvent['postback']['data'] : null;
    }

    public function getUserProfile()
    {
        $response = $this->bot->getProfile($this->userId);

        if ($response->isSucceeded()) {
            return $response->getJSONDecodedBody();
        }
        Log::debug($response->getHTTPStatus() . PHP_EOL . $response->getRawBody());
    }

    public function getRawEvent()
    {
        return $this->rawEvent;
    }

    /**
     * event checkers
     */
    public function isMessageEvent(): bool
    {
        return ($this->eventType === 'message');
    }

    public function isFollowEvent(): bool
    {
        return ($this->eventType === 'follow');
    }

    public function isUnfollowEvent(): bool
    {
        return ($this->eventType === 'unfollow');
    }

    public function isJoinEvent(): bool
    {
        return ($this->eventType === 'join');
    }

    public function isLeaveEvent(): bool
    {
        return ($this->eventType === 'leave');
    }

    public function isMemberJoinEvent(): bool
    {
        return ($this->eventType === 'memberJoined');
    }

    public function isMemberLeaveEvent(): bool
    {
        return ($this->eventType === 'memberLeft');
    }

    public function isPostBackEvent(): bool
    {
        return ($this->eventType === 'postback');
    }

    public function isDeviceLinkEvent(): bool
    {
        return ($event['type'] === 'things' && $event['things']['type'] === 'link');
    }

    public function isDeviceUnlinkEvent(): bool
    {
        return ($event['type'] === 'things' && $event['things']['type'] === 'unlink');
    }

    public function isBeaconEvent(): bool
    {
        return ($this->eventType === 'beacon');
    }

    public function isAccountLinkEvent(): bool
    {
        return ($this->eventType === 'accountLink');
    }

    /**
     * message events checkers
     */
    public function isTextMessage(): bool
    {
        return ($this->messageEventType === 'text');
    }

    public function isImageMessage(): bool
    {
        return ($this->messageEventType === 'image');
    }

    public function isVideoMessage(): bool
    {
        return ($this->messageEventType === 'video');
    }

    public function isAudioMessage(): bool
    {
        return ($this->messageEventType === 'audio');
    }

    public function isFileMessage(): bool
    {
        return ($this->messageEventType === 'file');
    }

    public function isLocationMessage(): bool
    {
        return ($this->messageEventType === 'location');
    }

    public function isStickerMessage(): bool
    {
        return ($this->messageEventType === 'sticker');
    }
}
