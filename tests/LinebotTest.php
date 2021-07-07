<?php

namespace Whchi\LaravelLineBotWrapper\Tests;

use LINE\LINEBot\Response;
use Mockery as m;
use Whchi\LaravelLineBotWrapper\LINEBotContext;

class LinebotTest extends TestCase
{
    protected $bot;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bot = m::mock(LINEBotContext::class);
    }

    protected function tearDown(): void
    {
        $this->bot = null;
        parent::tearDown();
    }

    public function testReply()
    {
        $response = m::mock(Response::class);
        $this->bot->shouldReceive('sdk')
                  ->with('replyText', ['reply_token', 'helloworld'])
                  ->once()
                  ->andReturn($response);
        $this->bot->sdk('replyText', ['reply_token', 'helloworld']);
    }
}
