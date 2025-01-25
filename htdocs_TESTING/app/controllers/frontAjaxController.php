<?php

namespace test\app\controllers;

use test\app\controllers\baseAjaxController;


require_once('ajaxLoader.php');


$ajax = new baseAjaxController();
$ajax->serve();


?>