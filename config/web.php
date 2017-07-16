<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/7/12
 * Time: 22:10
 */

return [
    'components' => [
        'request' => [
            'class' => 'lingyin\web\Request',
        ],
        'response' => [
            'class' => 'lingyin\web\Response'
        ],
        'uri' => [
            'class' => 'lingyin\web\http\Uri',
            'protocol' => 'REQUEST_URI',
        ],
        'route' => [
            'class' => 'lingyin\web\router\Route',
            'rules' => [
                'root' => [
                    'path' => '',
                    'defaults' => [
                        'controller' => 'Home',
                        'action' => 'index'
                    ]
                ],
                'default' => [
                    'path' => '{controller}{/action}',
                    'allows' => 'route',// or get or post等 ,默认为route不区分请求方法
                    'tokens' => [
                        'controller' => '[\w-]+',
                        'action' => '[\w-]+'
                    ],
                    'defaults' => [
                        'action' => 'index'
                    ]
                ],
            ]
        ]
    ]
];