<?php

$template = [
    [
        'type' => 'sticker',
        'packageId' => '1',
        'stickerId' => '1',
    ],
    [
        'type' => 'location',
        'title' => 'my location',
        'address' => '〒150-0002 東京都渋谷区渋谷２丁目２１−１',
        "lat" => 35.65910807942215,
        "lon" => 139.70372892916203,
    ],
    [
        'type' => 'image_carousel',
        'columns' => collect([
            [
                'imageUrl' => 'https://storage.googleapis.com/www-leadercampus-com-tw/leader/images/channel/201902/channel-5c6a55246f23c.jpg',
                'action' => [
                    'type' => 'uri',
                    'label' => 'Google',
                    'uri' => 'https://www.google.com',
                ],
            ],
            [
                'imageUrl' => 'https://storage.googleapis.com/www-leadercampus-com-tw/leader/images/channel/201902/channel-5c6a55246f23c.jpg',
                'action' => [
                    'type' => 'uri',
                    'label' => '創新學院官網',
                    'uri' => 'https://www.leadercampus.com.tw',
                ],
            ],
            [
                'imageUrl' => 'https://storage.googleapis.com/www-leadercampus-com-tw/leader/images/channel/201902/channel-5c6a55246f23c.jpg',
                'action' => [
                    'type' => 'uri',
                    'label' => '天下官網',
                    'uri' => 'https://www.cw.com.tw',
                ],
            ],
        ]),
    ],
    [
        'type' => 'carousel',
        'columns' => collect([
            [
                'title' => '數位轉型',
                'text' => '數位轉型關鍵對談',
                'thumbnailImageUrl' => 'https://storage.googleapis.com/www-leadercampus-com-tw/leader/images/channel/201902/channel-5c6a55246f23c.jpg',
                'actions' => collect([
                    [
                        'type' => 'uri',
                        'label' => 'Google',
                        'uri' => 'https://www.google.com',
                    ],
                ]),
            ],
            [
                'title' => '學會學：學習之道',
                'text' => '學會學：學習之道',
                'thumbnailImageUrl' => 'https://storage.googleapis.com/www-leadercampus-com-tw/leader/images/article/201903/course-5c9c73495ccda.jpg',
                'actions' => collect([
                    [
                        'type' => 'uri',
                        'label' => '創新學院官網',
                        'uri' => 'https://www.leadercampus.com.tw',
                    ],
                ]),
            ],
            [
                'title' => '數位轉型從領導力開始',
                'text' => '數位轉型從領導力開始',
                'thumbnailImageUrl' => 'https://storage.googleapis.com/www-leadercampus-com-tw/leader/images/article/201901/course-5c3489c4ddcd5.jpg',
                'actions' => collect([
                    [
                        'type' => 'uri',
                        'label' => '天下官網',
                        'uri' => 'https://www.cw.com.tw',
                    ],
                ]),
            ],
            [
                'title' => 'postback title',
                'text' => 'postback text',
                'thumbnailImageUrl' => 'https://i.imgur.com/cVFzY9F.png',
                'actions' => collect([
                    [
                        'type' => 'postback',
                        'label' => 'postback event',
                        'displayText' => 'postback event',
                        'data' => 'helloworld',
                    ],
                ]),
            ],
        ]),
    ],
    [
        'type' => 'confirm',
        'text' => 'confirm text',
        'actions' => collect([
            [
                'type' => 'uri',
                'label' => '是',
                'uri' => 'http://google.com',
            ],
            [
                'type' => 'postback',
                'label' => '否',
                'displayText' => '動作 2',
                'data' => '資料 2',
            ],
        ]),
    ],
];
