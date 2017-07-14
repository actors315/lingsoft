<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/7/12
 * Time: 22:10
 */

return [
    'components' =>[
        'request' => [
            'class' => 'lingyin\web\Request',
        ],
        'uri' => [
            'class' => 'lingyin\web\http\Uri',
            'protocol' => 'REQUEST_URI',
        ],
        'route' => [
            'class' => 'lingyin\web\router\Route',
            'rules' => [
                '<controller:[\w-]+>/<action:[\w-]+>' => '<controller>/<action>',
                '<controller:[\w-]+>' => '<controller>/index',
                '' => 'index/index'
            ]
        ]
    ]
];