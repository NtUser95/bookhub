<?php
require __DIR__ . '/../init.php';

App\App::init();
echo App\App::$kernel->launch();
