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
                'modules' => [
                    'path' => '{module}{/controller,action}',
                    'tokens' => [
                        'module' => '(user|order)+',
                        'controller' => '[\w-]+',
                        'action' => '[\w-]+'
                    ],
                    'defaults' => [
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
                'root' => [
                    'path' => '',
                    'defaults' => [
                        'controller' => 'Index',
                        'action' => 'index'
                    ]
                ],
            ]
        ],
        'view' => [
            'class' => 'lingyin\web\View',
            'renderWorker' => [
                'html' => [
                    'class' => 'lingyin\view\smarty\ViewRenderer'
                ]
            ]
        ]
    ]
];