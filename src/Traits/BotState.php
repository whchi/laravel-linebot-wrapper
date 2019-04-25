<?php

namespace Whchi\LaravelLineBotWrapper\Traits;

use Cache;
use Whchi\LaravelLineBotWrapper\Exceptions\BotStateException;
use Illuminate\Support\Arr;
trait BotState
{
    /**
     * session state
     *
     * @var string json
     */
    private $initState;

    public function initState(array $state): void
    {
        $this->initState = Arr::dot($state);
    }

    public function buildState()
    {
        Cache::forever($this->sessionStateCacheKey, $this->initState);
    }

    public function setState(array $state): void
    {
        $data = Cache::pull($this->sessionStateCacheKey);

        $state = Arr::dot($state);
        array_walk($data, function (&$ele, $idx) use ($state) {
            if (array_key_exists($idx, $state)) {
                $ele = $state[$idx];
            }
        });

        Cache::forever($this->sessionStateCacheKey, $data);
    }

    /**
     * 取得 state by key
     *
     * @param string $key parent.child
     * @return array state data
     */
    public function getState(string $key)
    {
        $data = Cache::get($this->sessionStateCacheKey);
        if (array_key_exists($key, $data)) {
            return $data[$key];
        }
        throw new BotStateException('method ' . __FUNCTION__ . ' error: undefined index "' . $key . '" in state');
    }

    public function resetState()
    {
        Cache::forget($this->sessionStateCacheKey);
        Cache::forever($this->sessionStateCacheKey, $this->initState);
    }
}
