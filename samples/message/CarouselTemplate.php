<?php

$template = [
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
];
