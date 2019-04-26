<?php

$template = [
    'baseUrl' => 'https://i.imgur.com/9kDkVpC.jpg',
    'baseSize' => [
        'width' => 750,
        'height' => 750,
    ],
    'video' => [
        'originalContentUrl' => 'https://00e9e64bacbd16a1aaa2201df467bfd6ca4b63367fdc173fe2-apidata.googleusercontent.com/download/storage/v1/b/aia-auto-tagging/o/temp%2FFunny%20rubbits%2010%20sec%20video.mp4',
        'previewImageUrl' => 'https://storage.googleapis.com/www-leadercampus-com-tw/leader/images/article/201901/course-5c3489c4ddcd5.jpg',
        'area' => [
            'x' => 0,
            'y' => 0,
            'width' => 375,
            'height' => 375,
        ],
        'externalLink' => [
            'linkUri' => 'https://example.com/see_more.html',
            'label' => 'See More',
        ],
    ],
    'actions' => collect([
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
