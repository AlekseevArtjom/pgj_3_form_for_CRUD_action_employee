<?php

namespace test;
use test\app\appClass;

//include loader file
require_once('main_loader.php');


//run application
$app = new appClass();
$app->run();

?>