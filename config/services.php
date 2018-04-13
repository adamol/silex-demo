<?php

$app['debug'] = true;

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

