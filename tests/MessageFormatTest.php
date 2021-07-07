<?php

namespace Whchi\LaravelLineBotWrapper\Tests;

use LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use Whchi\LaravelLineBotWrapper\MessageBuilders\Base;
use Whchi\LaravelLineBotWrapper\MessageBuilders\LINEMessageBuilder;

class MessageFormatTest extends TestCase
{
    protected $builder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->builder = new LINEMessageBuilder();
    }

    protected function tearDown(): void
    {
        $this->builder = null;
        parent::tearDown();
    }


    public function testBuildQuickReply()
    {
        $obj = new Base();
        $fn = self::getNonPublicMethod('buildQuickReply', Base::class);
        $template = $this->getTemplate('QuickReplyTemplate');
        $rst = $fn->invokeArgs($obj, [$template]);
        $this->assertInstanceOf(QuickReplyMessageBuilder::class, $rst);
    }

    /**
     * @dataProvider generalProvider
     */
    public function testGeneralFormat(string $format)
    {
        $template = $this->getTemplate($format);
        if (str_starts_with($format, 'Flex')) {
            $format = 'Flex';
        }
        if ($format === 'MultipleMessage') {
            $format = 'Multi';
        }
        $method = "build{$format}Message";
        $fn = self::getNonPublicMethod($method, LINEMessageBuilder::class);
        switch ($format) {
            case 'Video':
            case 'Text':
            case 'Sticker':
            case 'Location':
            case 'Image':
            case 'Audio':
                $fn->invokeArgs($this->builder, [$template]);
                break;
            default:
                $fn->invokeArgs($this->builder, [$format, $template]);
                break;
        }
        $this->assertTrue(true);
    }


    public function generalProvider(): array
    {
        return [
            ['Audio'],
            ['Button'],
            ['Carousel'],
            ['Confirm'],
            ['Flex'],
            ['FlexCarousel'],
            ['Image'],
            ['ImageCarousel'],
            ['ImageMap'],
            ['Location'],
            ['Sticker'],
            ['Text'],
            ['Video'],
            ['MultipleMessage']
        ];
    }

    private function getTemplate(string $key): array
    {
        include(__DIR__ . "/../samples/message/{$key}.php");
        return $template;
    }
}
