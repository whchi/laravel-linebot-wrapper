<?php

namespace Whchi\LaravelLineBotWrapper\Tests;

use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use Mockery as m;
use Whchi\LaravelLineBotWrapper\LINEBotContext;
use Whchi\LaravelLineBotWrapper\Traits\MessageHelper;

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

    /**
     * @test
     */
    public function it_should_reply_message()
    {
        $this->bot->shouldReceive('replyText')
                          ->with('come')
                          ->once();

        $this->bot->replyText('come');
    }


}
