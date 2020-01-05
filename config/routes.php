<?php

return [
    // To create a standalone route:
    // 'pattern/to/your/route' => 'controller-id/action-id'

    // To create a standalone route with more configurations:
    /*[
        'pattern' => 'pattern/to/your/route',
        'route' => 'controller-id/action-id',
        'verb' => ['GET']
    ]*/

    // To create a Active route (Active Controller):
    /*[
        'class' => 'yii\rest\UrlRule',
        'controller' => 'controller-id',
        //'pluralize' => true,
        'extraPatterns' => [
            'GET test' => 'test',
        ],
    ]*/
];