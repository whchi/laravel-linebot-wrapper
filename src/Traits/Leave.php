<?php

namespace Whchi\LaravelLineBotWrapper\Traits;

trait Leave
{
    public function leave()
    {
        if (isset($this->groupId)) {
            $this->bot->leaveGroup($this->groupId);
        } else {
            $this->bot->leaveGroup($this->roomId);
        }
    }
}
