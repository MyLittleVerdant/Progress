<?php
return [
    'work' => true,
    'beget' => [
        'login' => '',
        'password' => ''
    ],
    'google_table_id' => '',
    'path' => [
        'report'            => '/home/z/zhenik/tgredmine-bot/public_html/assets/report/',
        'log'               => '/home/z/zhenik/tgredmine-bot/public_html/logs/',
        'site_fall'         => '/home/z/zhenik/tgredmine-bot/public_html/assets/site_fall.json',
        'disable_notify'    => '/home/z/zhenik/tgredmine-bot/public_html/config/disable_notify.json',
        'google_key'        => '/home/z/zhenik/tgredmine-bot/public_html/config/service_key.json',
        'site_lifetime'        => '/home/z/zhenik/tgredmine-bot/public_html/config/site_lifetime.json',
    ],
    'bot' => [
        'url' => '',
        'token' => '',
    ],
    'redmine' => [
        'url' => '',
        'api_key' => ''
    ],
    'database' => [
        "redmine" => [
            'host' => 'localhost',
            'port' => '3306',
            'user' => '',
            'pass' => '',
            'db' => 'zhenik_redm1'
        ],
        "bx" => [
            'host' => 'localhost',
            'port' => '3306',
            'user' => '',
            'pass' => '',
            'db' => 'zhenik_barabash'
        ]
    ],

    'chats' => [
        [
            'tg' => '' //megadev
        ]
    ],
    'observers' => [
        [
            'tg' =>'' ,
            'redmine' => 34,
            'name' => 'Илья'
        ],
    ],
    'projects' => [
        94 => [
            'name' => 'DocDent',
            'members' => [38],
        ],
        77=>[
            'name'=>'DocDeti',
            'members'=>[38],
        ],
        73=>[
            'name'=>'DocMed',
            'members'=>[38],
        ],
    ],
  'members' => [
    [
      'tg' => '',
      'redmine' => 1,
      'name' => 'Женя',
      'admin' => true,
      'notify' => [
        'onWorkCount' => false,
        'sumTimerDay' => false,
        'activeTimer' => false,
        'lastTimer'   => false,
        'isKnowledge' => false,
        'startTask'   => true,
        'morningStartWork' => false,
      ],
    ],

    [
      'tg' => '',
      'redmine' => 38,
      'name' => 'Артем',
      'admin' => false,
      'notify' => [
        'onWorkCount' => true,
        'sumTimerDay' => true,
        'activeTimer' => true,
        'lastTimer'   => true,
        'isKnowledge' => true,
        'startTask'   => true,
        'morningStartWork' => true,
      ],
    ],
  ]
];