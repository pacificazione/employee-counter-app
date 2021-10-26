<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\Employee',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                '/' => 'site/index',
                'employee/index' => 'employee/index',
                'employee/create' => 'employee/create',
                'employee/update' => 'employee/update',
                'employee/view' => 'employee/view',
                'employee/delete' => 'employee/delete',

                'site/login' => 'site/login',
                'site/signup' => 'site/signup',
                'site/logout'=> 'site/logout',

                'department/index'=> 'department/index',
                'department/create' => 'department/create',
                'department/add' => 'department/add',
                'department/remove' => 'department/remove',
                'department/update' => 'department/update',
                'department/view' => 'department/view',
                'department/delete' => 'department/delete',
            ],
        ],

    ],
    'params' => $params,
];
