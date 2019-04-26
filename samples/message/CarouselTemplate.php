<?php

$template = [
    'imageAspectRatio' => 'square',
    'imageSize' => 'cover',
    'columns' => collect([
        [
            'title' => '數位轉型',
            'text' => '數位轉型關鍵對談',
            'thumbnailImageUrl' => 'https://storage.googleapis.com/www-leadercampus-com-tw/leader/images/channel/201902/channel-5c6a55246f23c.jpg',
            'imageBackgroundColor' => '#000000',
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
        [
            'title' => 'datetimepicker title',
            'text' => 'datetimepicker text',
            'thumbnailImageUrl' => 'https://i.imgur.com/cVFzY9F.png',
            'actions' => collect([
                [
                    'type' => 'datetimepicker',
                    'label' => 'Select date',
                    'data' => 'storeId=12345',
                    'mode' => 'datetime',
                    'initial' => '2017-12-25t00:00',
                    'max' => '2018-01-24t23:59',
                    'min' => '2017-12-25t00:00',
                ],
            ]),
        ],
        [
            'title' => 'cameraRoll title',
            'text' => 'cameraRoll text',
            'thumbnailImageUrl' => 'https://i.imgur.com/cVFzY9F.png',
            'actions' => collect([
                [
                    'type' => 'cameraRoll',
                    'label' => 'camera roll',
                ],
            ]),
        ],
        [
            'title' => 'location title',
            'text' => 'location text',
            'thumbnailImageUrl' => 'https://i.imgur.com/cVFzY9F.png',
            'actions' => collect([
                [
                    'type' => 'location',
                    'label' => 'location',
                ],
            ]),
        ],
        [
            'title' => 'camera title',
            'text' => 'camera text',
            'thumbnailImageUrl' => 'https://i.imgur.com/cVFzY9F.png',
            'actions' => collect([
                [
                    'type' => 'camera',
                    'label' => 'camera',
                ],
            ]),
        ],
    ]),
];
