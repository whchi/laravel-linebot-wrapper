<?php

namespace Whchi\LaravelLineBotWrapper;

use Whchi\LaravelLineBotWrapper\Core\MessageBuilders\LINEMessageBuilder;
use Whchi\LaravelLineBotWrapper\Exceptions\ContextException;
use Whchi\LaravelLineBotWrapper\Traits\BotState;
use Whchi\LaravelLineBotWrapper\Traits\Leave;
use Whchi\LaravelLineBotWrapper\Traits\MessagePusher;
use Whchi\LaravelLineBotWrapper\Traits\MessageReplier;
use Whchi\LaravelLineBotWrapper\Traits\UserProfile;

class LINEBotContext extends LINEMessageBuilder
{
    use MessageReplier, MessagePusher, BotState, UserProfile, Leave;

    protected $pushTo;

    /**
     * push_api, can be userId / groupId / roomId
     *
     * @param string $to
     * @return void
     */
    public function setPushTo(string $to)
    {
        $this->pushTo = $to;
    }

    public function getMessagePayload()
    {
        return $this->isMessageEvent() ? $this->rawEvent['message'] : null;
    }

    public function getPostbackPayload()
    {
        return $this->isPostBackEvent() ? $this->rawEvent['postback']['data'] : null;
    }

    /**
     * Works on audio / video / image messages
     */
    public function getMessageStreamData()
    {
        if (!in_array($this->messageEventType, ['audio', 'video', 'image'])) {
            throw new ContextException('Calling ' . __FUNCTION__ . ' error, Invalid messageEventType');
        }

        $id = $this->getMessagePayload()['id'];
        $response = $this->bot->getMessageContent($id);

        if ($response->isSucceeded()) {
            return $response->getRawBody();
        }
        throw new ContextException($response->getHTTPStatus() . PHP_EOL . $response->getRawBody());
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
