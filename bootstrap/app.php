<?php

use Slim\Factory\AppFactory;

require 'container.php';

$app = AppFactory::create();

require 'middleware.php';

require '../routes/web.php';
