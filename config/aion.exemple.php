<?php

return [

    'website_name'       => 'Aion server',
    'aion_version'       => '4.9',
    'link_facebook'      => '#',
    'link_twitter'       => '#',
    'link_youtube'       => '#',
    'languages'          => ['en', 'fr'],
    'contactMail'        => 'admin@hostname',
    'forumUrl'           => '#',
    'minimumAccessLevel' => 3, // Minimum accessLevel for access to the back office
    'enable_weddings'    => false, // Display block with last 5 weddings

    'page' => [
        'online_players' => [
            'display_map'              => true, // If set to true, display the map name on 'Online players'
            'display_map_access_level' => 0, // Minimum access level to display map
            'display_level'            => true
        ]
    ],

    // When you are connect you can unlock your character
    'spawn' => [
        'elyos' => [
            'world_id' => '120010000',
            'x'        => '1275.5504',
            'y'        => '1169.5846',
            'z'        => '215.21492',
            'heading'  => 30
        ],
        'asmodians' => [
            'world_id' => '120010000',
            'x'        => '1275.5504',
            'y'        => '1169.5846',
            'z'        => '215.21492',
            'heading'  => 30
        ]
    ],

    'cache' => [
        'top_vote'      => 10, // Every 10 minutes, we clear the cache of top voter
        'online_number' => 2 // Every 2 minutes, we clear count of players online
    ],

    'allopass' => [
        'enabled'     => false,
        'url'         => 'https://payment.allopass.com/buy/buy.apu?ids={IDS}&idd={IDD}',
        'pointsGiven' => 4000,
        'documentId'  => ''
    ],

    'paypal' => [
        'enabled'           => false,
        'email'             => 'admin@hostname',
        'maxShopPoints'     => 1000000,
        'points_per_euro'   => 5000, // 5000 Shop's Points equal 1€
        'currency_code'     => 'EUR', // Look paypal for that
        'currency_display'  => '€'
    ],

    'servers' => [
        'Game' => [
            'enabled'   => true,
            'ip'    => '127.0.0.1',
            'port'  => 2106
        ],
        'Login' => [
            'enabled'   => true,
            'ip'    => '127.0.0.1',
            'port'  => 7777
        ],
        'TS' => [
            'enabled'   => false,
            'ip'        => '127.0.0.1',
            'port'      => 9987
        ],
        'Discord' => [
            'enabled'   => false,
            'url'       => '#'
        ],
    ],

    // On the back office you can download logs from the server
    'logs' => [
        'enabled'   => true,
        'type'      => 'files', // Type can be files or db
        'path' => '/path/to/log/files/',
        'files' => [
            [
                'file'         => 'adminaudit',
                'extension'    => '.log',
                'access_level' => 1
            ],
            [
                'file'         => 'audit',
                'extension'    => '.log',
                'access_level' => 1
            ],
            [
                'file'         => 'chat',
                'extension'    => '.log',
                'access_level' => 1
            ],
            [
                'file'         => 'console',
                'extension'    => '.log',
                'access_level' => 1
            ],
            [
                'file'         => 'error',
                'extension'    => '.log',
                'access_level' => 1
            ],
            [
                'file'         => 'exchange',
                'extension'    => '.log',
                'access_level' => 1
            ],
            [
                'file'         => 'kill',
                'extension'    => '.log',
                'access_level' => 1
            ],
            [
                'file'         => 'mail',
                'extension'    => '.log',
                'access_level' => 1
            ],
            [
                'file'         => 'warn',
                'extension'    => '.log',
                'access_level' => 1
            ]

        ]
    ],

    // Vote System
    'vote' => [
        'activated'            => true, // You can activate or not the vote system
        'check'                => true, // Enable system to verify if the user has realy vote
        'boost'                => false,
        'boost_value'          => 50,
        'shop_points_per_vote' => 100,
        'shop_point_name'      => 'Shop Point',
        'links' => [
            [
                'name'    => 'RPG',
                'link'    => 'http://www.rpg-paradize.com/?page=vote&vote={ID}',
                'referer' => 'http://www.rpg-paradize.com/{server-page}', // Use for check if the user has realy vote
                'cooldown'  => 7200,
            ],
            [
                'name'    => 'Gowonda',
                'link'    => 'http://www.gowonda.com/vote.php?server_id={ID}',
                'referer' => 'http://www.gowonda.com/{server_page}', // Use for check if the user has realy vote
                'cooldown'  => 7200,
            ],
        ]
    ],

    // Level is use for the shop, more you buy on the shop more you account level-up
    'enable_account_level' => false,
    'levels' => [
        [
            'level' => 0,
            'price' => 0
        ],
        [
            'level' => 1,
            'price' => 5
        ],
        [
            'level' => 2,
            'price' => 20
        ],
        [
            'level' => 3,
            'price' => 45
        ],
        [
            'level' => 4,
            'price' => 80
        ],
        [
            'level' => 5,
            'price' => 125
        ]
    ]

];
