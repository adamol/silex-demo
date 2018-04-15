<?php

require __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../src/app.php';

$jobRepository = $app['jobs.repository'];
$jobWorker = $app['jobs.worker'];

while (true) {
    $pendingJobs = $jobRepository->findPendingJobs();

    if (! empty($pendingJobs)) {
        foreach ($pendingJobs as $job) {
            $jobWorker->processJob($job);
        }
    }


    sleep(5);
}

