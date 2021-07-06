<?php

namespace Whchi\LaravelLineBotWrapper\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

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
        if (!Cache::has($this->botSessionId)) {
            Cache::forever($this->botSessionId, $this->initState);
        }
    }

    public function setState(array $state): void
    {
        $data = Cache::pull($this->botSessionId);

        $state = Arr::dot($state);
        array_walk(
            $data,
            function (&$ele, $idx) use ($state) {
                if (array_key_exists($idx, $state)) {
                    $ele = $state[$idx];
                }
            }
        );

        Cache::forever($this->botSessionId, $data);
    }

    /**
     * get state by key
     *
     * @param string $key parent.child
     */
    public function getState(string $key)
    {
        $data = Cache::get($this->botSessionId);
        return Arr::get($data, $key);
    }

    public function resetState()
    {
        Cache::forget($this->botSessionId);
        Cache::forever($this->botSessionId, $this->initState);
    }
}
