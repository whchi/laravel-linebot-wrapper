<?php

$template = [
    'baseUrl' => 'https://i.imgur.com/9kDkVpC.jpg',
    'baseSize' => [
        'width' => 750,
        'height' => 750,
    ],
    'actions' => collect([
        [
            'type' => 'uri',
            'linkUri' => 'http://google.com',
            'area' => [
                'x' => 0,
                'y' => 0,
                'width' => 375,
                'height' => 375,
            ],
        ],
        [
            'type' => 'message',
            'text' => 'message',
            'area' => [
                'x' => 0,
                'y' => 375,
                'width' => 375,
                'height' => 375,
            ],
        ],
    ]),
];
