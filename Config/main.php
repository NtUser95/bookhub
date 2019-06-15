<?php
return [
    'route' => [
        'rules' => [
            'managebook/edit?id=\d+' => 'managebook/edit',
            'users/index?page=\d+&sort=\w+&by=\w+' => 'users/index',
            '?page=\d+&sort=\w+&by=\w+' => 'users/index',
            '?page=\d+' => 'users/index',
            'towns/index?page=\d+' => 'towns/index',
            'towns/index?page=\d+&sort=\w+&by=\w+' => 'towns/index',
        ],
        'defaultRoute' => 'books/index',
    ],
];