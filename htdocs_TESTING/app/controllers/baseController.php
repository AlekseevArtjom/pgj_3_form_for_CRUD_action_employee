<?php
namespace test\app\controllers;


class baseController 
{
	protected $model_config;
	protected $view_config;
	protected $main_config;
	
	public function __construct(){  //более правильно для большого проекта сделать конфигуратор через синглетон или реестр
		
		//read config file into tmp array
		$raw_config_string =file_get_contents('app_config.txt', true);
		$tmp_pair_config_arr = explode(';', preg_replace('/(\s+)/', '',$raw_config_string));
		array_pop($tmp_pair_config_arr);
		
		foreach($tmp_pair_config_arr as $tmp){
			if(isset($config_pair)) unset($config_pair);
			$config_pair = explode('=', $tmp);
			$tmp_config[$config_pair[0]] = $config_pair[1]; 
		}
		
		//Database setttings
		$this->model_config['CONNECTION_TYPE'] = $tmp_config['DB_TYPE'];
		$this->model_config['HOST'] = $tmp_config['DB_HOST'];
		$this->model_config['PORT'] = $tmp_config['DB_PORT'];
		$this->model_config['USER'] = $tmp_config['DB_USER'];
		$this->model_config['PASSWORD'] = $tmp_config['DB_PASSWORD'];
		$this->model_config['DB'] = $tmp_config['DB'];
		$this->model_config['SHEMA'] = $tmp_config['DB_SCHEMA'];
		
		//Views settings
		$this->view_config['MAIN_PAGE_STYLE'] = $tmp_config['PAGE_STYLE'];
		
		//Main settings
		$this->main_config['APP_NAME'] = $tmp_config['APP_NAME'];
		$this->main_config['PATH_TO_ERROR_PAGE'] = $tmp_config['PATH_TO_ERROR_PAGE'];
		$this->main_config['PATH_TO_FRONT_AJAX_CONTROLLER'] = $tmp_config['PATH_TO_FRONT_AJAX_CONTROLLER'];
		$this->main_config['PATH_TO_JS_SCRIPT'] = $tmp_config['PATH_TO_JS_SCRIPT'];
		$this->main_config['PATH_TO_MAIN_STYLE'] = $tmp_config['PATH_TO_MAIN_STYLE'];
				
	}	
}
?>