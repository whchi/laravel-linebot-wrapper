<?php

$template = [
    'title' => 'title',
    'text' => 'text',
    'thumbnailImageUrl' => 'https://i.imgur.com/cVFzY9F.png',
    'defaultAction' => [
        'type' => 'uri',
        'label' => 'cw official',
        'uri' => 'http://cw.com.tw',
    ],
    'imageAspectRatio' => 'rectangle',
    'imageSize' => 'cover',
    'actions' => [
        [
            'type' => 'uri',
            'label' => '動作 1',
            'uri' => 'http://google.com',
        ],
        [
            'type' => 'postback',
            'label' => '動作 2',
            'displayText' => '動作 2',
            'data' => '資料 2',
        ],
        [
            'type' => 'message',
            'label' => '動作 3',
            'text' => '動作 3',
        ],
    ],
];
