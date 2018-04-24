<?php

use Symfony\Component\HttpFoundation\Request;

$app->error(function(\Exception $e, $code) {
    $app['logger']->warning($e->getMessage());
});

$app->before(function (Request $request) {
    if (strpos($request->headers->get('Content-Type'), 'application/json') === 0) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});
