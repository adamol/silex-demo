<?php

namespace Framework;

class JobsWorker
{
    private $container;

    private $jobHandlers = [
        'image_resize' => 'books.image_resizer',
        'send_email' => 'mailer'
    ];

    public function __construct(\Silex\Application $container)
    {
        $this->container = $container;
    }

    public function processJob($job)
    {
        if (! in_array($job->getType(), $this->jobHandler)) {
            throw new \RuntimeException(
                'No Job Handler associated with retrieved job.'
            );
        }

        $handler = $this->jobHandlers[$job->getType()];
        $this->container[$handler]->handle($job);
    }
}
