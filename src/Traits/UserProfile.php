<?php

namespace Whchi\LaravelLineBotWrapper\Traits;

trait UserProfile
{
    public function getUserProfile()
    {
        $response = $this->bot->getProfile($this->userId);

        if ($response->isSucceeded()) {
            return $response->getJSONDecodedBody();
        }
        Log::debug($response->getHTTPStatus() . PHP_EOL . $response->getRawBody());

        return $this->bot->getProfile($userId);
    }
}
