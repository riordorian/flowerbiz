<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Mm6OWYWQSQWMOTE0OS8O6segbGmDMlXc',
            'baseUrl' => ''
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'budyaga\users\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/login'],

        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'exportInterval' => 1,
                    'categories' => ['flower'],
                    'logFile' => '@app/log.txt',
                ],
            ],
        ],
        'db' => $db,

        'i18n' => [
            'translations' => [
                'users' => [
                    'sourceLanguage' => 'ru',
                    'class' => yii\i18n\PhpMessageSource::className(),
                    'basePath' => '@app/vendor/budyaga/yii2-users/messages',
                    'fileMap' => [
                        '/models/user' => 'users.php',
                        'module' => 'users.php',
                    ],
                    'forceTranslation' => true
                ],
            ],
        ],

        'formatter' => [
            'nullDisplay' => '-'
        ],

        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'vkontakte' => [
                    'class' => 'budyaga\users\components\oauth\VKontakte',
                    'clientId' => 'XXX',
                    'clientSecret' => 'XXX',
                    'scope' => 'email'
                ],
                'google' => [
                    'class' => 'budyaga\users\components\oauth\Google',
                    'clientId' => 'XXX',
                    'clientSecret' => 'XXX',
                ],
                'facebook' => [
                    'class' => 'budyaga\users\components\oauth\Facebook',
                    'clientId' => 'XXX',
                    'clientSecret' => 'XXX',
                ],
                'github' => [
                    'class' => 'budyaga\users\components\oauth\GitHub',
                    'clientId' => 'XXX',
                    'clientSecret' => 'XXX',
                    'scope' => 'user:email, user'
                ],
                'linkedin' => [
                    'class' => 'budyaga\users\components\oauth\LinkedIn',
                    'clientId' => 'XXX',
                    'clientSecret' => 'XXX',
                ],
                'live' => [
                    'class' => 'budyaga\users\components\oauth\Live',
                    'clientId' => 'XXX',
                    'clientSecret' => 'XXX',
                ],
                'yandex' => [
                    'class' => 'budyaga\users\components\oauth\Yandex',
                    'clientId' => 'XXX',
                    'clientSecret' => 'XXX',
                ],
                'twitter' => [
                    'class' => 'budyaga\users\components\oauth\Twitter',
                    'consumerKey' => 'XXX',
                    'consumerSecret' => 'XXX',
                ],
            ],
        ],


        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/signup' => '/user/user/signup',
                //                '/login' => '/user/user/login',
                '/logout' => '/user/user/logout',
                '/requestPasswordReset' => '/user/user/request-password-reset',
                '/resetPassword' => '/user/user/reset-password',
                '/profile' => '/user/user/profile',
                '/retryConfirmEmail' => '/user/user/retry-confirm-email',
                '/confirmEmail' => '/user/user/confirm-email',
                '/unbind/<id:[\w\-]+>' => '/user/auth/unbind',
                '/oauth/<authclient:[\w\-]+>' => '/user/auth/index',
                '<action:>' => 'site/<action>',

                '/admin/' => 'user/user/login',
                '/admin/clients/' => 'clients/index',
                '/admin/clients/<action:>' => 'clients/<action>',

                '/admin/clients-groups/' => 'clients-groups/index/',
                '/admin/clients-groups/<action:>' => 'clients-groups/<action>',

                '/admin/clients-types/' => 'clients-types/index/',
                '/admin/clients-types/<action:>' => 'clients-types/<action>',

                '/admin/gift-recipients/' => 'gift-recipients/index/',
                '/admin/gift-recipients/<action:>' => 'gift-recipients/<action>',

                '/admin/events/' => 'events/index/',
                '/admin/events/<action:>' => 'events/<action>',

                '/admin/loyalty-programs/' => 'loyalty-programs/create/',
                '/admin/loyalty-programs/<action:>' => 'loyalty-programs/<action>',

                '/admin/catalog-sections/' => 'catalog-sections/index',
                '/admin/catalog-sections/<action:>' => 'catalog-sections/<action>',

                '/admin/catalog-products/' => 'catalog-products/index/',
                '/admin/catalog-products/<action:>' => 'catalog-products/<action>',

                '/admin/providers/' => 'providers/index/',
                '/admin/providers/<action:>' => 'providers/<action>',

                '/admin/good-supply/' => 'good-supply/index/',
                '/admin/good-supply/<action:>' => 'good-supply/<action>',

                '/admin/good-writes-off/' => 'good-writes-off/index/',
                '/admin/good-writes-off/<action:>' => 'good-writes-off/<action>',

                '/admin/money-accounts/' => 'money-accounts/index/',
                '/admin/money-accounts/<action:>' => 'money-accounts/<action>',

                '/admin/money-movements/' => 'money-movements/index/',
                '/admin/money-movements/<action:>' => 'money-movements/<action>',

                '/admin/cashboxes/' => 'cashboxes/index/',
                '/admin/cashboxes/<action:>' => 'cashboxes/<action>',

                '/admin/cash-periods/' => 'cash-periods/index/',
                '/admin/cash-periods/<action:>' => 'cash-periods/<action>',

                '/admin/orders/' => 'admin-orders/index/',
                '/admin/orders/<action:>' => 'admin-orders/<action>',

                '/admin/operators/' => 'operators/index/',
                '/admin/operators/<action:>' => 'operators/<action>',

                '/admin/managers/' => 'managers/index/',
                '/admin/managers/<action:>' => 'managers/<action>',

                '/admin/reports/<action:>' => 'reports/<action>',

                #VIRTUAL SECTIONS#
                '/admin/clients-events/<action:>' => 'clients-events/<action>',
                '/admin/loyalty-programs-steps/<action:>' => 'loyalty-programs-steps/<action>',

                # TERMINAL
                '/terminal/' => 'terminal/index/',
                '/terminal/orders-schedule/' => 'orders-schedule/index/',
                '/terminal/orders-schedule/<action:>' => 'orders-schedule/<action>',
                '/terminal/orders/' => 'orders/index/',
                '/terminal/orders/<action:>' => 'orders/<action>',

            ],
            'suffix' => '/',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],


    ],
    'modules' => [
        'user' => [
            'class' => 'budyaga\users\Module',
            'userPhotoUrl' => 'http://example.com/uploads/user/photo',
            'userPhotoPath' => '@frontend/web/uploads/user/photo',
            'customViews' => [
                'login' => '@app/views/site/login'
            ],
        ],
    ],

    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
