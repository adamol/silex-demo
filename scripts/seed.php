<?php

include __DIR__.'/../vendor/autoload.php';

$app = include __DIR__.'/../src/app.php';

$app[Seeders\DatabaseSeeder::class]->seed();

//$files = new DirectoryIterator(__DIR__.'/../db/seeds');
//foreach ($files as $file) {
//    if (!$file->isDot()) {
//        $lines = file(__DIR__.'/../db/seeds/'.$file->getFilename());
//        echo "Running seeder {$file->getFilename()}.\n";
//        foreach ($lines as $line) {
//            echo 'Executing: ' . $line;
//            $app['db']->exec($line);
//        }
//        echo "\n";
//    }
//}
