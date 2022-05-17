<?php

require_once __DIR__.'/../vendor/autoload.php';

use App\App;

$app = new App();

$app->render($_SERVER["REQUEST_URI"]);