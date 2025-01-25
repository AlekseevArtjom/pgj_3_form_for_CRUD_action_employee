<?php

namespace test\app\controllers;

use test\app\controllers\baseController;
use test\app\controllers\employeeAjaxController;


class baseAjaxController extends baseController
{
	public function __construct(){ parent::__construct(); }
	
	
	protected function check_request_for_ajax($type, $input){ 
		
		if($input==NULL) {
			echo "Fill the form!";exit;
		}
								
		switch($type){
			case "POST": 	$type_of_input=$_POST; break;
			case "GET":	$type_of_input=$_GET; break;
			default: 		{echo "NOT ALLOWED REQUEST TYPE";exit;} break;
		}

		foreach($type_of_input as $key => $value){ 
			
			if($value!=NULL){
				
				if(is_int($value) || is_float($value)) 
					$input[$key]=$value;  
				else 
					$input[$key]=$value;   
			}	
			
		} unset($value); unset($key);
		
				
		foreach($input as $current_key=>$current_value) {
			
			if($input[$current_key]==NULL) {
				echo " / ".htmlspecialchars($current_key)." / missed";exit;
			}
			
		} unset($current_value); unset($current_key);             
				
		return $input;	
	}
	
	
	
	public function serve(){
		
		//создаем шаблонный массив
		if(!empty($_POST)){
			foreach($_POST as $key=>$value) $input[$key]=NULL; 
			$type = 'POST';
		}else if(!empty($_GET)){
			foreach($_GET as $key=>$value) $input[$key]=NULL; 
			$type = 'GET';
		}
		
		//проверяем запрос
		$input=$this->check_request_for_ajax($type, $input);
		
		//выбираем действие и выполняем его
		$controller_action=$input['asck_for_action'];
		
		switch($controller_action)
		{
			case "show_emp": $action = new employeeAjaxController($input); $result = $action->showEmployee();  break;
			case "add_emp": $action = new employeeAjaxController($input); $result = $action->addEmployee();  break;
			case "update_emp": $action = new employeeAjaxController($input); $result= $action->updateEmployee();  break;
			case "del_emp": $action = new employeeAjaxController($input); $result= $action->delEmployee();  break;
	
			default: echo "Can not do this!";exit;break;
		}
		
	}
	
	
}

?>
