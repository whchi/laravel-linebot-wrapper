<?php

namespace Whchi\LaravelLineBotWrapper\Traits;

trait Leave
{
    public function leaveGroup()
    {
        $this->bot->leaveGroup($this->groupId);
    }

    public function leaveRoom()
    {
        $this->bot->leaveRoom($this->roomId);
    }
}
