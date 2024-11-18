<?php

return [

    'template' => [
        'templateHeaderStart(1)'            =>     TEMPLATE_PATH . 'templateHeaderStart(1).php',
        'TemplateHeaderEnd(2)'              =>     TEMPLATE_PATH . 'TemplateHeaderEnd(2).php',
        'NavBar(3)'                         =>     TEMPLATE_PATH . 'NavBar(3).php',
        ':view'                             =>      ':action_view',
        'Footer(4)'                         =>     TEMPLATE_PATH . 'Footer(4).php',
        'TemplateEnd(5)'                    =>     TEMPLATE_PATH . 'TemplateEnd(5).php'
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
