<?php

$app['debug'] = true;

$app['tables'] = [
    'books'
];

$app['db'] = function() {
	$dbname = getenv('environment') === 'testing'
		? 'silex_demo_test'
		: 'silex_demo';

    return new PDO(
		"mysql:host=localhost;dbname=$dbname",
		getenv('DB_USER') ?: 'root',
		getenv('DB_PASS') ?: 'root'
	);
};

$app['db_manager'] = function($app) {
    return new \Framework\DatabaseManager($app['db'], $app['tables']);
};

