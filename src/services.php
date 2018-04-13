<?php

$app['debug'] = true;

$app['db'] = function() {
	$dbname = getenv('environment') !== 'testing'
		? 'silex_demo'
		: 'silex_demo_test';

    return new PDO(
		"mysql:host=localhost;dbname=$dbname",
		getenv('DB_USER'),
		getenv('DB_PASS')
	);
};

