<?php

namespace Seeders;

class DatabaseSeeder
{
    private $seeders = [
        BooksTableSeeder::class,
        //OrdersTableSeeder::class
    ];

    private $app;

    public function __construct(\Silex\Application $app)
    {
        $this->app = $app;
    }

    public function seed()
    {
        foreach ($this->seeders as $seeder) {
            $this->app[$seeder]->seed();
        }
    }
}
