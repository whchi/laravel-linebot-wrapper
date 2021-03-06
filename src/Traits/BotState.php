<?php

namespace Whchi\LaravelLineBotWrapper\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Whchi\LaravelLineBotWrapper\Exceptions\BotStateException;

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
     * 取得 state by key
     *
     * @param  string $key parent.child
     * @return array state data
     */
    public function getState(string $key)
    {
        $data = Cache::get($this->botSessionId);
        if (array_key_exists($key, $data)) {
            return $data[$key];
        }
        throw new BotStateException('method ' . __FUNCTION__ . ' error: undefined index "' . $key . '" in state');
    }

    public function resetState()
    {
        Cache::forget($this->botSessionId);
        Cache::forever($this->botSessionId, $this->initState);
    }
}
