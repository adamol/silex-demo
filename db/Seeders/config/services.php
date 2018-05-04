<?php

$app[Seeders\DatabaseSeeder::class] = function($app) {
    return new Seeders\DatabaseSeeder($app);
};

$app[Seeders\BooksTableSeeder::class] = function($app) {
    return new Seeders\BooksTableSeeder($app['doctrine.entity_manager']);
};

$app[Seeders\OrdersTableSeeder::class] = function($app) {
    return new Seeders\OrdersTableSeeder($app['doctrine.entity_manager']);
};
