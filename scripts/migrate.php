<?php

include __DIR__.'/../vendor/autoload.php';

$app = include __DIR__.'/../src/app.php';

$app['db_manager']->dropAllTables();

$files = new DirectoryIterator(__DIR__.'/../db/migrations');
foreach ($files as $file) {
    if (!$file->isDot()) {
        echo "Running migration {$file->getFilename()} \n";
		$app['db']->exec(
			file_get_contents(__DIR__.'/../db/migrations/'.$file->getFilename())
		);
    }
}
