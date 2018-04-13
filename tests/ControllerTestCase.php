<?php

use Silex\WebTestCase;

class ControllerTestCase extends WebTestCase
{
    public function setUp()
    {
        parent::setUp();

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
