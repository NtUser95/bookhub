<?php
return [
	'route' => [
		'rules' => [
			'users/index?page=\d+' => 'users/index',
			'users/index?page=\d+&sort=\w+&by=\w+' => 'users/index',
			'?page=\d+&sort=\w+&by=\w+' => 'users/index',
			'?page=\d+' => 'users/index',
			'towns/index?page=\d+' => 'towns/index',
			'towns/index?page=\d+&sort=\w+&by=\w+' => 'towns/index',
		],
		'defaultRoute' => 'books/index',
	],
];