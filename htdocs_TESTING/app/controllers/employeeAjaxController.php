<?php

namespace test\app\controllers;

use test\app\controllers\baseAjaxController;
use test\app\models\mainTableModel;
use test\app\models\workTableModel; 


class employeeAjaxController extends baseAjaxController
{
	private $id;
	private $data;
	
	
	public function __construct($input=null){ 
		parent::__construct(); 
		
		if(isset($input['id']))
		$this->id = (int)$input['id'];
		else $this->id = 0;
		
		if(isset($input['data']))
		$this->data = json_decode($input['data']);
		else $this->data = '';
	}
	
	
	public function showEmployee(){
		
		$main_table = new mainTableModel($this->main_config, $this->model_config);
		
		//$main_data = $main_table->getEmpDataById($this->id);  //два пути построения моделей БД 1)модели для каждой таблицы как в laravel
		//$work_data = $work_table->getEmpWorkById($this->id);  // 2) модель для "объекта сотрудник" 
																// сейчас т.к. проект маленький нет смысла делать шадлон для большого фреймворка,
																// поэтому далее реализую модель для сотрудника на базе mainTableModel
		try{
			$data = $main_table->getAllEmpDataById($this->id);
			echo json_encode($data);
		} 
		catch(\PDOException $e) { echo json_encode(['response'=>'err']); exit; }
	}
	
	public function delEmployee(){
		
		$result = null;
		
		if($this->id != 0){
			try{
				$main_table = new mainTableModel($this->main_config, $this->model_config);
				$result = $main_table->delEmp($this->id);
			}
			catch(\PDOException $e) { echo  json_encode(['response'=>'err']); exit; }
		}
		 
		 
		 if(!empty($result)) echo json_encode(['response'=>'OK']);
		 else echo json_encode(['response'=>'err']);	
	}
	
	
	public function addEmployee(){
		
		$data_checked = array();
		$data_checked['family_name']=htmlspecialchars($this->data->family_name, ENT_QUOTES );
		$data_checked['name']= htmlspecialchars($this->data->name, ENT_QUOTES );
		$data_checked['second_name']= htmlspecialchars($this->data->second_name, ENT_QUOTES );
		$data_checked['sex']= htmlspecialchars($this->data->sex, ENT_QUOTES );
		$data_checked['birth_date']= htmlspecialchars($this->data->birth_date, ENT_QUOTES );
		$data_checked['workPlaces'] = array();
		
		for($i=0; $i< count($this->data->workPlaces); $i++){
		
			$data_checked['workPlaces'][$i]['work_id']=0;
			$data_checked['workPlaces'][$i]['company_name']=htmlspecialchars($this->data->workPlaces[$i]->company_name, ENT_QUOTES );
			$data_checked['workPlaces'][$i]['work_start']=htmlspecialchars($this->data->workPlaces[$i]->work_start, ENT_QUOTES );
			$data_checked['workPlaces'][$i]['work_end']=htmlspecialchars($this->data->workPlaces[$i]->work_end, ENT_QUOTES );
		}
		
		
		
		if(preg_match('/[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])/', $data_checked['birth_date']) != 1) {
			echo json_encode(['response'=>'Неправильный формат даты рождения!']); exit;
		}
		
		for($j=0;$j<count($this->data->workPlaces);$j++){
			
			if(preg_match('/[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])/', $data_checked['workPlaces'][$j]['work_start']) != 1) 
			{echo json_encode(['response'=>'Неправильный формат даты начала работы!']); exit;}
			if(preg_match('/[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])/', $data_checked['workPlaces'][$j]['work_end']) != 1) 
			{echo json_encode(['response'=>'Неправильный формат даты окончания работы!']); exit;}
		
		}
		
		
		
		if(!empty($data_checked) ){
			try{
				$main_table = new mainTableModel($this->main_config, $this->model_config);
				$main_table->addEmp($data_checked);
			}
			catch(\PDOException $e) { echo json_encode(['response'=>'err']); exit;}
			
			echo json_encode(['response'=>'OK']);
		}
		else echo json_encode(['response'=>'err']);
	}
	
	
	public function updateEmployee(){
		
		$data_checked = array();
		$data_checked['id']=htmlspecialchars($this->data->id, ENT_QUOTES );
		$data_checked['family_name']=htmlspecialchars($this->data->family_name, ENT_QUOTES );
		$data_checked['name']= htmlspecialchars($this->data->name, ENT_QUOTES );
		$data_checked['second_name']= htmlspecialchars($this->data->second_name, ENT_QUOTES );
		$data_checked['sex']= htmlspecialchars($this->data->sex, ENT_QUOTES );
		$data_checked['birth_date']= htmlspecialchars($this->data->birth_date, ENT_QUOTES );
		$data_checked['workPlaces'] = array();
		
		for($i=0; $i< count($this->data->workPlaces); $i++){
			
			$data_checked['workPlaces'][$i]['work_id']=htmlspecialchars($this->data->workPlaces[$i]->work_id, ENT_QUOTES );
			$data_checked['workPlaces'][$i]['company_name']=htmlspecialchars($this->data->workPlaces[$i]->company_name, ENT_QUOTES );
			$data_checked['workPlaces'][$i]['work_start']=htmlspecialchars($this->data->workPlaces[$i]->work_start, ENT_QUOTES );
			$data_checked['workPlaces'][$i]['work_end']=htmlspecialchars($this->data->workPlaces[$i]->work_end, ENT_QUOTES );
		
		}
		

		
		if(preg_match('/[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])/', $data_checked['birth_date']) != 1) {
			echo json_encode(['response'=>'Неправильный формат даты рождения!']); exit;
		}
		
		for($j=0;$j<count($this->data->workPlaces);$j++){
			
			if(preg_match('/[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])/', $data_checked['workPlaces'][$j]['work_start']) != 1) 
			{echo json_encode(['response'=>'Неправильный формат даты начала работы!']); exit;}
			if(preg_match('/[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])/', $data_checked['workPlaces'][$j]['work_end']) != 1) 
			{echo json_encode(['response'=>'Неправильный формат даты окончания работы!']); exit;}
		
		}
		
		
		
		if(!empty($data_checked) ){
			try{
				$main_table = new mainTableModel($this->main_config, $this->model_config);
				$main_table->updateEmp($data_checked);
			}
			catch(\PDOException $e) { echo json_encode(['response'=>'err']); exit; }
			
			echo json_encode(['response'=>'OK']);
		}
		else echo json_encode(['response'=>'err']);
		
		
	}
}
?>