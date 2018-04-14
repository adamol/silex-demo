<?php

use Silex\WebTestCase;

class ControllerTestCase extends WebTestCase
{
    protected $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = $this->createClient();

        $this->app['db_manager']->resetAllIncrements();

        $this->app['db']->beginTransaction();
    }

    public function tearDown()
    {
        $this->app['db']->rollBack();
    }

    public function createApplication()
    {
        $app = require __DIR__.'/../src/app.php';
        $app['debug'] = true;
        unset($app['exception_handler']);

        return $app;
    }

}
