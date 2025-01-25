<?php

namespace test\app\models;

use test\app\modelsbaseModel;


class mainTableModel extends baseModel
{
	public function __construct($main_config, $model_config){
		parent::__construct($main_config, $model_config);
	}
	
	//get data from main table
	public function getMainTable(){
		$query_string = 'SELECT id as "Номер", 
								family_name as "Фамилия",
								name as "Имя",
								second_name as "Отчество",
								birth_date as "Дата рождения",
								sex as "Пол"
						 FROM employee.main_table
						 order by id; ';
		return parent::extract_from_db_PDO($query_string, 'utf8', []); 
	}
	
	public function getAllEmpDataById($id){
		$query_string = 'SELECT 
						 t.id, 
						 t.family_name,
						 t.name,
						 t.second_name,
						 t.birth_date,
						 t.sex,
						 t1.work_start,
						 t1.work_end,
						 t1.company_name,
						 t1.id as work_id
						 FROM employee.main_table t
						 LEFT JOIN employee.old_work_places t1 ON t.id = t1.emp_id
						 WHERE t.id=:p_id
						 order by id; ';
		return parent::extract_from_db_for_ajax_PDO($query_string, 'utf8', ['p_id'=>$id]); 
	}
	
	public function delEmp($id){
		$query_string = 'DELETE FROM employee.main_table where id=:p_id; ';
		return parent::extract_from_db_for_ajax_PDO($query_string, 'utf8', ['p_id'=>$id]); 
		
	}
	
	public function addEmp($data_checked){
		$query_string = 'insert into employee.main_table(family_name,name,second_name,sex,birth_date) 
							 values(:p_fname, :p_name, :p_otch, :p_sex,:p_bdate); ';
		$insertedId = parent::extract_from_db_for_ajax_PDO($query_string, 'utf8', ['p_fname'=>$data_checked['family_name'],
																     'p_name'=>$data_checked['name'],
																     'p_otch'=>$data_checked['second_name'] ,
																	 'p_sex'=>$data_checked['sex'] ,
																	 'p_bdate'=>$data_checked['birth_date'] ]); 
		
			
		for($j=0;$j<count($data_checked['workPlaces']);$j++){
			$query_string = 'insert into employee.old_work_places(work_start,work_end,company_name,emp_id) values(:p_ws, :p_we,:p_wp, :p_emp_id); ';
			$result = parent::extract_from_db_for_ajax_PDO($query_string, 'utf8', [
																     'p_wp'=>$data_checked['workPlaces'][$j]['company_name'],
																     'p_ws'=>$data_checked['workPlaces'][$j]['work_start'],
																	 'p_we'=>$data_checked['workPlaces'][$j]['work_end'],
																	 'p_emp_id'=>$insertedId
																	  ]);
		}		
	}
	
	
	public function updateEmp($data_checked){
		$query_string = ' update employee.main_table    
							set family_name = :p_fname,
							name = :p_name,
							second_name = :p_otch,
							sex = :p_sex,
							birth_date = :p_bdate
						  where id = :p_id; ';
		
		$result = parent::extract_from_db_for_ajax_PDO($query_string, 'utf8', ['p_fname'=>$data_checked['family_name'],
																     'p_name'=>$data_checked['name'],
																     'p_otch'=>$data_checked['second_name'] ,
																	 'p_sex'=>$data_checked['sex'] ,
																	 'p_bdate'=>$data_checked['birth_date'],
																	 'p_id'=>$data_checked['id'] ]);
		
		for($i=0;$i<count($data_checked['workPlaces']);$i++){
			$query_string = ' update employee.old_work_places
								set work_start = :p_ws,
								    work_end = :p_we,
									company_name = :p_wp
							  where id = :p_work_id; ';
			
			
			if($data_checked['workPlaces'][$i]['work_id'] !=''){
			$result = parent::extract_from_db_for_ajax_PDO($query_string, 'utf8', [
																     'p_wp'=>$data_checked['workPlaces'][$i]['company_name'],
																     'p_ws'=>$data_checked['workPlaces'][$i]['work_start'],
																	 'p_we'=>$data_checked['workPlaces'][$i]['work_end'],
																	 'p_work_id'=>$data_checked['workPlaces'][$i]['work_id']
																	  ]);
			}else{
				$query_string = 'insert into employee.old_work_places(work_start,work_end,company_name,emp_id) values(:p_ws, :p_we,:p_wp, :p_emp_id); ';
				$result = parent::extract_from_db_for_ajax_PDO($query_string, 'utf8', [
																     'p_wp'=>$data_checked['workPlaces'][$i]['company_name'],
																     'p_ws'=>$data_checked['workPlaces'][$i]['work_start'],
																	 'p_we'=>$data_checked['workPlaces'][$i]['work_end'],
																	 'p_emp_id'=>$data_checked['id']
																	  ]);
			}
				
		}
		
		
	}
	
}
?>