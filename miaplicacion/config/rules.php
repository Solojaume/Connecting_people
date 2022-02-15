<?php
return [
     '<controller:[\w-]+>/<action:[\w-]+>'=>'<controller>/<action>',
    ['class' => 'yii\rest\UrlRule',
    'pluralize'=>false,
    'controller' => ['usuario'],
],
['class' => 'yii\rest\UrlRule',
    'controller' => ['comentario'],
    'pluralize'=>false,
    //'extraPatterns'=>['POST authenticate'=>'authenticate']
],
['class' => 'yii\rest\UrlRule',
'controller' => ['usuario'],
'pluralize'=>false,
'extraPatterns'=>['POST login'=>'login',
    'OPTIONS authenticate'=>'authenticate',
    ]
]
 
];