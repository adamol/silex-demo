<?php

include __DIR__.'/../../vendor/autoload.php';

$app = include __DIR__.'/../../src/bootstrap.php';

$files = new DirectoryIterator(__DIR__.'/../seeds');
foreach ($files as $file) {
    if (!$file->isDot()) {
        $lines = file(__DIR__.'/../seeds/'.$file->getFilename());
        foreach ($lines as $line) {
            echo 'Executing: ' . $line;
            $app['db']->exec($line);
        }
    }
}
