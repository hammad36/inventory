<?php

return [

    'template' => [
        'templateHeaderStart'            =>     TEMPLATE_PATH . 'templateHeaderStart.php',
        'templateHeaderEnd'              =>     TEMPLATE_PATH . 'templateHeaderEnd.php',
        'navbar'                         =>     TEMPLATE_PATH . 'navbar.php',
        ':view'                             =>      ':action_view',
        'footer'                         =>     TEMPLATE_PATH . 'footer.php',
        'templateEnd'                    =>     TEMPLATE_PATH . 'templateEnd.php'
    ],

    'header_resources' => [
        'css' => [
            'productStyles' => CSS . 'productStyles.css',
            'invoiceStyles' => CSS . 'invoiceStyles.css',
            'style'         => CSS . 'style.css'
        ],

    ],
    'footer_resources' => [

        'js' => [
            'index'       => JS . 'index.js',
        ]
    ]

];
