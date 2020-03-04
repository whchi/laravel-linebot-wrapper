<?php

$template = [
    // sticker
    [
        'type' => 'sticker',
        'packageId' => '1',
        'stickerId' => '1',
    ],
    // location
    [
        'type' => 'location',
        'title' => 'my location',
        'address' => '〒150-0002 東京都渋谷区渋谷２丁目２１−１',
        "lat" => 35.65910807942215,
        "lon" => 139.70372892916203,
    ],
    // image carousel
    [
        'type' => 'image_carousel',
        'columns' => collect(
            [
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
            ]
        ),
    ],
    // carousel
    [
        'type' => 'carousel',
        'columns' => collect(
            [
            [
                'title' => '數位轉型',
                'text' => '數位轉型關鍵對談',
                'thumbnailImageUrl' => 'https://storage.googleapis.com/www-leadercampus-com-tw/leader/images/channel/201902/channel-5c6a55246f23c.jpg',
                'actions' => collect(
                    [
                    [
                        'type' => 'uri',
                        'label' => 'Google',
                        'uri' => 'https://www.google.com',
                    ],
                    ]
                ),
            ],
            [
                'title' => '學會學：學習之道',
                'text' => '學會學：學習之道',
                'thumbnailImageUrl' => 'https://storage.googleapis.com/www-leadercampus-com-tw/leader/images/article/201903/course-5c9c73495ccda.jpg',
                'actions' => collect(
                    [
                    [
                        'type' => 'uri',
                        'label' => '創新學院官網',
                        'uri' => 'https://www.leadercampus.com.tw',
                    ],
                    ]
                ),
            ],
            [
                'title' => '數位轉型從領導力開始',
                'text' => '數位轉型從領導力開始',
                'thumbnailImageUrl' => 'https://storage.googleapis.com/www-leadercampus-com-tw/leader/images/article/201901/course-5c3489c4ddcd5.jpg',
                'actions' => collect(
                    [
                    [
                        'type' => 'uri',
                        'label' => '天下官網',
                        'uri' => 'https://www.cw.com.tw',
                    ],
                    ]
                ),
            ],
            [
                'title' => 'postback title',
                'text' => 'postback text',
                'thumbnailImageUrl' => 'https://i.imgur.com/cVFzY9F.png',
                'actions' => collect(
                    [
                    [
                        'type' => 'postback',
                        'label' => 'postback event',
                        'displayText' => 'postback event',
                        'data' => 'helloworld',
                    ],
                    ]
                ),
            ],
            ]
        ),
    ],
    // confirm
    [
        'type' => 'confirm',
        'text' => 'confirm text',
        'actions' => collect(
            [
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
            ]
        ),
    ],
    // flex
    [
        'type' => 'flex',
        'contents' => [
            'type' => 'carousel',
            'contents' =>
            collect(
                [
                [
                    'styles' => collect(
                        [
                        'body' => [
                            'backgroundColor' => '#aaaaaa',
                        ],
                        ]
                    ),
                    'direction' => 'rtl',
                    'hero' =>
                    [
                        'type' => 'image',
                        'size' => 'full',
                        'aspectRatio' => '20:13',
                        'aspectMode' => 'cover',
                        'url' => 'https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_5_carousel.png',
                    ],
                    'body' =>
                    [
                        'type' => 'box',
                        'layout' => 'vertical',
                        'spacing' => 'sm',
                        'contents' =>
                        collect(
                            [
                            [
                                'type' => 'text',
                                'text' => 'Arm Chair, White',
                                'wrap' => true,
                                'weight' => 'bold',
                                'size' => 'xl',
                            ],
                            [
                                'type' => 'box',
                                'layout' => 'baseline',
                                'contents' =>
                                collect(
                                    [
                                    [
                                        'type' => 'text',
                                        'text' => '$49',
                                        'wrap' => true,
                                        'weight' => 'bold',
                                        'size' => 'xl',
                                        'flex' => 0,
                                    ],
                                    [
                                        'type' => 'text',
                                        'text' => '.99',
                                        'wrap' => true,
                                        'weight' => 'bold',
                                        'size' => 'sm',
                                        'flex' => 0,
                                    ],
                                    ]
                                ),
                            ],
                            ]
                        ),
                    ],
                    'footer' =>
                    [
                        'type' => 'box',
                        'layout' => 'vertical',
                        'spacing' => 'sm',
                        'contents' =>
                        collect(
                            [
                            [
                                'type' => 'button',
                                'style' => 'primary',
                                'action' =>
                                [
                                    'type' => 'uri',
                                    'label' => 'Add to Cart',
                                    'uri' => 'https://linecorp.com',
                                ],
                            ],
                            [
                                'type' => 'button',
                                'action' =>
                                [
                                    'type' => 'uri',
                                    'label' => 'Add to wishlist',
                                    'uri' => 'https://linecorp.com',
                                ],
                            ],
                            ]
                        ),
                    ],
                ],
                [
                    'hero' =>
                    [
                        'type' => 'image',
                        'size' => 'full',
                        'aspectRatio' => '20:13',
                        'aspectMode' => 'cover',
                        'url' => 'https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_6_carousel.png',
                    ],
                    'body' =>
                    [
                        'type' => 'box',
                        'layout' => 'vertical',
                        'spacing' => 'sm',
                        'contents' =>
                        collect(
                            [
                            [
                                'type' => 'text',
                                'text' => 'Metal Desk Lamp',
                                'wrap' => true,
                                'weight' => 'bold',
                                'size' => 'xl',
                            ],
                            [
                                'type' => 'box',
                                'layout' => 'baseline',
                                'flex' => 1,
                                'contents' =>
                                collect(
                                    [
                                    [
                                        'type' => 'text',
                                        'text' => '$11',
                                        'wrap' => true,
                                        'weight' => 'bold',
                                        'size' => 'xl',
                                        'flex' => 0,
                                    ],
                                    [
                                        'type' => 'text',
                                        'text' => '.99',
                                        'wrap' => true,
                                        'weight' => 'bold',
                                        'size' => 'sm',
                                        'flex' => 0,
                                    ],
                                    ]
                                ),
                            ],
                            [
                                'type' => 'text',
                                'text' => 'Temporarily out of stock',
                                'wrap' => true,
                                'size' => 'xxs',
                                'margin' => 'md',
                                'color' => '#ff5551',
                                'flex' => 0,
                            ],
                            ]
                        ),
                    ],
                    'footer' =>
                    [
                        'type' => 'box',
                        'layout' => 'vertical',
                        'spacing' => 'sm',
                        'contents' =>
                        collect(
                            [
                            [
                                'type' => 'button',
                                'flex' => 2,
                                'style' => 'primary',
                                'color' => '#aaaaaa',
                                'action' =>
                                [
                                    'type' => 'uri',
                                    'label' => 'Add to Cart',
                                    'uri' => 'https://linecorp.com',
                                ],
                            ],
                            [
                                'type' => 'button',
                                'action' =>
                                [
                                    'type' => 'uri',
                                    'label' => 'Add to wish list',
                                    'uri' => 'https://linecorp.com',
                                ],
                            ],
                            ]
                        ),
                    ],
                ],
                [
                    'body' =>
                    [
                        'type' => 'box',
                        'layout' => 'vertical',
                        'spacing' => 'sm',
                        'contents' =>
                        collect(
                            [
                            [
                                'type' => 'button',
                                'flex' => 1,
                                'gravity' => 'center',
                                'action' =>
                                [
                                    'type' => 'uri',
                                    'label' => 'See more',
                                    'uri' => 'https://linecorp.com',
                                ],
                            ],
                            ]
                        ),
                    ],
                ],
                ]
            ),
        ],
    ],
];
