<?php
if( !defined('DS')) define('DS',DIRECTORY_SEPARATOR);
if( !defined('BASE_DIR')) define('BASE_DIR',__DIR__);
if( !defined('PS')) define('PS', PATH_SEPARATOR);

set_include_path(get_include_path().
									PS.BASE_DIR.
									PS.BASE_DIR.DS.'app'.
									PS.BASE_DIR.DS.'app'.DS.'config'.
									PS.BASE_DIR.DS.'app'.DS.'controllers'.
									PS.BASE_DIR.DS.'app'.DS.'models'.
									PS.BASE_DIR.DS.'app'.DS.'views');
									
require_once('appClass.php');
	
require_once('baseController.php');									
require_once('startPageController.php');	
//require_once('frontAjaxController.php');
								
require_once('baseModel.php');	
require_once('mainTableModel.php');	

require_once('baseView.php');	
require_once('startPageView.php');	

//require_once('startPageTemplate.html');						
									
?>									
