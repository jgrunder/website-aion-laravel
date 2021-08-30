<?php

return [
    'meta'      => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'       => "Aion server", // set false to total remove
            'description' => "Private server Aion", // set false to total remove
            'separator'   => ' - ',
            'keywords'    => ['aion', 'serveur', 'fun', 'pvp', 'serveur privee', 'serveur aion', 'gratuit'],
        ],

        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null
        ]
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'Aion server', // set false to total remove
            'description' => 'Private server Aion', // set false to total remove
            'url'         => '#',
            'type'        => 'website',
            'site_name'   => 'Aion server',
            'images'      => [],
        ]
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
          'card'        => 'Private server Aion',
          'site'        => '@Real_Aion',
        ]
    ]
];
