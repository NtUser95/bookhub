<?php
require __DIR__ . '/../init.php';

use App\App;

App::init();
echo App::$kernel->launch();
