<?php

namespace Whchi\LaravelLineBotWrapper\Traits;

use Log;
trait UserProfile
{
    public function getUserProfile()
    {
        $response = $this->bot->getProfile($this->userId);

        if ($response->isSucceeded()) {
            return $response->getJSONDecodedBody();
        }
        Log::debug($response->getHTTPStatus() . PHP_EOL . $response->getRawBody());
    }
}
