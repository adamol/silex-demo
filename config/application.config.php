<?php

require __DIR__ . "/services.php";
require __DIR__ . "/providers.php";
require __DIR__ . "/middleware.php";

$modules = [
    'Posts'
];

foreach ($modules as $module) {
    require __DIR__ . "/../src/$module/config/services.php";
    require __DIR__ . "/../src/$module/config/routes.php";
}

