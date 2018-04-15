<?php

use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\Session;

$app['debug'] = true;

$app['tables'] = [
    'books',
    'book_items',
    'orders'
];

$app['session'] = function() {
    return (getenv('ENVIRONMENT') === 'testing')
        ? new Session(new MockArraySessionStorage())
        : new Session();
};

$app['db'] = function() {
	$dbname = getenv('ENVIRONMENT') === 'testing'
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

$app['file_uploader'] = function($app) {
    return new \Framework\FileUploader();
};

$app['jobs.repository'] = function($app) {
    return new \Framework\JobsRepository($app['db']);
};

$app['jobs.worker'] = function($app) {
    return new \Framework\JobsWorker($app);
};

$app['swift.mailer'] = function($app) {
    $transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 2525))
      ->setUsername($app['mailtrap.username'])
      ->setPassword($app['mailtrap.password']);

    return new Swift_Mailer($transport);
};

// @TODO: Make sure this PHP extension is enabled
$app['image_manager'] = function() {
    return new \Intervention\Image\ImageManager(['driver' => 'imagick']);
};

$app['storage'] = function() {
    private $storage;
    return new \Framework\Storage();
};

$app['mailtrap.username'] = getenv('MAILTRAP_USER');
$app['mailtrap.password'] = getenv('MAILTRAP_PASS');

$app['mailer'] = function($app) {
    return new \Framework\Mailer($app['swift.mailer'], $app['jobs.repository']);
};

$app['http_client'] = function($app) {
    return new \GuzzleHttp\Client();
};

$app['stripe.api_key'] = getenv('STRIPE_API_KEY');

$app['encryption.method' => getenv('ENCRYPTION_METHOD');
$app['encryption.key' => getenv('ENCRYPTION_KEY');
