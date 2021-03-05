<?php

return [
    'default' => 'local',

    'disks' => [
        'local' => [
            'root' => \Ssf\Copy\Tools\Helpers::env('LOCAL_ROOT', "")
        ],

        'sftp' => [
            'root'   => '/',
            'params' => [
                'host'       => 'localhost',
                'user'       => 'user',
                'password'   => null,
                'port'       => 22,
                'privateKey' => null,

                'passphrase'  => null,
                'useAgent'    => false,
                'timeout'     => 10,
                'maxTries'    => 3,
                'fingerprint' => null,
                'checker'     => null
            ]
        ]
    ],
];