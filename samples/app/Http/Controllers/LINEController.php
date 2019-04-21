<?php
namespace App\Http\Controllers;

use App\Events\SaveLineBotSessionEvent;
use Illuminate\Http\Request;

class LineController extends Controller
{
    protected $context;
    /**
     * bot state structure
     *
     * @var array
     */
    protected $botState;

    public function __construct()
    {
        $this->context = \App::make('LINEBotContext');
        $this->botState = [
            'status' => 0,
            'orderInfo' => [
                'hello' => 'world',
            ],
        ];
        $this->context->initState($this->botState);
    }

    public function index(Request $request)
    {
        $lineInput = $request->all();
        $events = collect($lineInput['events']);

        $events->each(function ($event) {
            $this->context->setContext($event);
            $this->context->buildState();
            event(new SaveLineBotSessionEvent($event));
            $template = [
                'text' => 'confirm text',
                'actions' => collect([
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
                ]),
            ];

            if ($this->context->isMessageEvent()) {
                $state = $this->context->getState('status');
                $orderInfoHellp = $this->context->getState('orderInfo.hello');
                $this->context->replyConfirmTemplate('confirm template text', $template);
            } else {
                $this->context->replyText('not implement yet');
            }
        });
    }
}
