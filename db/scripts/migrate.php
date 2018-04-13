<?php

include __DIR__.'/../../vendor/autoload.php';

$app = include __DIR__.'/../../src/bootstrap.php';

$app['db']->exec('DROP TABLE posts');

$files = new DirectoryIterator(__DIR__.'/../migrations');
foreach ($files as $file) {
    if (!$file->isDot()) {
		$app['db']->exec(
			file_get_contents(__DIR__.'/../migrations/'.$file->getFilename())
		);
    }
}
