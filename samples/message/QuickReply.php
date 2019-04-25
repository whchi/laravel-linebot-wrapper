<?php

$template = [
    'quickReply' => [
        'items' => collect([
            [
                'type' => 'action',
                'imageUrl' => 'https://example.com/sushi.png',
                'action' => [
                    'type' => 'postback',
                    'label' => 'postback event',
                    'displayText' => 'postback event',
                    'data' => 'helloworld',
                ],
            ],
            [
                'type' => 'action',
                'imageUrl' => 'https://example.com/tempura.png',
                'action' => [
                    'type' => 'message',
                    'label' => 'text',
                    'text' => 'text',
                ],
            ],
        ]),
    ],
];
