<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Whchi\LaravelLineBotWrapper\Context;

class LinebotEntrypoint extends Controller
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed|Context
     */
    private $context;
    /**
     * @var array
     */
    private $botState;

    public function __construct()
    {
        $this->context = app(Context::class);
        $this->botState = [
            'status' => 0,
            'orderInfo' => [
                'hello' => 'world',
            ],
        ];
        $this->context->initState($this->botState);
    }

    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Whchi\LaravelLineBotWrapper\Exceptions\MessageBuilderException
     */
    public function __invoke(Request $request)
    {
        $lineInput = $request->all();
        $events = collect($lineInput['events']);
        $events->each(
            function ($event) {
                $this->context->setContext($event);
                $this->context->buildState();
                $template = [
                    'text' => 'confirm text',
                    'actions' => [
                        [
                            'type' => 'uri',
                            'label' => 'Yes',
                            'uri' => 'http://google.com',
                        ],
                        [
                            'type' => 'postback',
                            'label' => 'No',
                            'displayText' => 'No',
                            'data' => 'data=no',
                        ],
                    ],
                ];

                if ($this->context->isMessageEvent()) {
                    $state = $this->context->getState('status');
                    $orderInfoHello = $this->context->getState('orderInfo.hello');
                    $this->context->replyConfirm('confirm template text', $template);
                } else {
                    $this->context->replyText('not implement yet');
                }
            }
        );
    }
}
