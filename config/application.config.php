<?php

$modules = [
    'Posts'
];

require __DIR__ . "/../src/services.php";
require __DIR__ . "/../src/providers.php";
require __DIR__ . "/../src/middleware.php";

foreach ($modules as $module) {
    require __DIR__ . "/../src/$module/config/services.php";
    require __DIR__ . "/../src/$module/config/routes.php";
}

