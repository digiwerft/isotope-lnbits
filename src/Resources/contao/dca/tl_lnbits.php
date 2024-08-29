<?php

$strTable = 'tl_lnbits';

// Table

$GLOBALS['TL_DCA'][$strTable] = [
    //Config
    'config' => [
        'dataContainer' => 'Table',
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary',
                'orderId' => 'index',
            ]
        ]
    ],
    //List
    'list' => [
        'sorting' => [
            'mode' => 1,
            'fields' => ['orderId'],
            'flag' => 11
        ],
        'label' => [
            'fields' => ['orderId'],
            'format' => '%s'
        ],
        'operations' => [
            'show' => [
                'label' => &$GLOBALS['TL_LANG'][$strTable]['show'],
                'href' => 'act=show',
                'icon' => 'show.gif'
            ],
        ]
    ],
    //Palettes
    'palettes' => [
        'default' => '{secupay_legend},orderId,paymentHash'
    ],
    //Fields
    'fields' => [
        'id' => [
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ],
        'orderId' => [
            'sql' => "varchar(255) NOT NULL default ''"
        ],
        'paymentHash' => [
            'sql' => "varchar(255) NOT NULL default ''"
        ]
    ]
];
