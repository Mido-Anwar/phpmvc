<?php

require __DIR__ . '/vendor/System/Application.php';
require __DIR__ . '/vendor/System/File.php';

use System\Application;
use System\File;
use App\Controllers\Users\users;
$file= new File(__DIR__);
$app = new Application($file);

new users();
