<?php

namespace test\app\models;

use test\app\modelsbaseModel;


class workTableModel extends baseModel
{
	public function __construct($main_config, $model_config){
		parent::__construct($main_config, $model_config);
	}
	
	
	public function getEmpWorkById($id){
		$query_string = 'SELECT * FROM employee.old_work_places WHERE emp_id=:p_emp_id; ';
		return parent::extract_from_db_for_ajax_PDO($query_string, 'utf8', ['p_emp_id'=>$id]); 
	}
	
	
}
?>