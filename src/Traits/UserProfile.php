<?php

namespace Whchi\LaravelLineBotWrapper\Traits;

use Whchi\LaravelLineBotWrapper\Exceptions\ContextException;
trait UserProfile
{
    public function getUserProfile()
    {
        $response = $this->bot->getProfile($this->userId);

        if ($response->isSucceeded()) {
            return $response->getJSONDecodedBody();
        }
        throw new ContextException($response->getHTTPStatus() . PHP_EOL . $response->getRawBody());
    }
}
