<?php

namespace test\app\views;

class baseView
{
	protected $main_config;
	protected $view_config;
	
	
	public function __construct($main_config, $view_config){
		$this->view_config = $view_config;
		$this->main_config = $main_config;
	}	
	
	
	protected function handle_error($system_message="", $user_message="") 
	{			
		if(isset($this->main_config['PATH_TO_ERROR_PAGE'])){
			$path_to_error_page = $model_config['PATH_TO_ERROR_PAGE'];
		
			$system_message_sequred=htmlspecialchars($system_message);
			$user_message_sequred=htmlspecialchars($user_message);
			$path_error=$path_to_error_page."?system_message={$system_message_sequred}&user_message={$user_message_sequred}"; 
			header("location: $path_error"); exit;
		}
		else {
			echo '</br>System error: '.$system_message_sequred;
			echo '</br>User error: '.$user_message_sequred;
			exit;
		}
	}
	
}
?>