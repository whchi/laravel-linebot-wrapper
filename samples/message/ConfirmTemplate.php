<?php

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
