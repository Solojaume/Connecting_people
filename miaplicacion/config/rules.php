<?php
return [
    ['class' => 'yii\rest\UrlRule',
    'pluralize'=>false,
    'controller' => ['usuario'],
],
['class' => 'yii\rest\UrlRule',
    'controller' => ['comentario'],
    'pluralize'=>false,
    //'extraPatterns'=>['POST authenticate'=>'authenticate']
]
 
];