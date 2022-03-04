<?php
return  [
    '<controller:[\w-]+>/<action:[\w-]+>'=>'<controller>/<action>',
    ['class' => 'yii\rest\UrlRule',
        'pluralize'=>false,
        'controller' => ['imagen','mach','mensajes','puntuaciones-review','reporte'],
    ],
    ['class' => 'yii\rest\UrlRule',
        'pluralize'=>false,
        'controller' => ['aspecto'],
    ],
    ['class' => 'yii\rest\UrlRule',
        'pluralize'=>false,
        'controller' => ['mensajes'],
        'extraPatterns'=>[
            'POST enviar'=>'enviar',
            'OPTIONS enviar'=> 'enviar'
        ]
    ],
    ['class' => 'yii\rest\UrlRule',
        'pluralize'=>false,
        'controller' => ['review'],
    ],
    ['class' => 'yii\rest\UrlRule',
        'controller' => ['usuario'],
        'pluralize'=>false,
        'extraPatterns'=>[
            'POST login'=>'login',
            'OPTIONS authenticate'=>'login',
        ]
    ]
];    
    