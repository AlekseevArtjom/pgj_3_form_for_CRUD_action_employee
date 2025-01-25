<?php

namespace test\app\views;

use test\app\views\baseView;


class startPageView extends baseView
{
	private $data_main_table;
	
	public function __construct($main_config, $view_config, $data_main_table){
		parent::__construct($main_config, $view_config);
		$this->data_main_table = $data_main_table;
		
	}	
	
	
	public function getAjaxControllerPath(){
		return $this->main_config['PATH_TO_FRONT_AJAX_CONTROLLER'];
	}
	
	public function getJSPath(){
		return $this->main_config['PATH_TO_JS_SCRIPT'];
	}
	
	public function getMainStylePath(){
		return $this->main_config['PATH_TO_MAIN_STYLE'];
	}
	
	
	public function getAppName(){
		return $this->main_config['APP_NAME'];
	}
	
	public function renderWelcomeBlock(){
		printf('<div id="welcome"><h2>Форма для работы с данными сотрудников</h2></div>');
	}
	
	public function renderMainTable(){
		
		printf('<div class="tableDiv" id="mainTable"><table><thead><tr>');
		foreach($this->data_main_table[0] as $column_name => $column_value){
			if($column_name) printf('<th> %s </th>', $column_name);
		}unset($column_name); unset($column_value);
		printf('</tr><thead><tbody>');
		
		foreach($this->data_main_table as $raw){
			printf('<tr>');
			foreach($raw as $column_name => $column_value){
				 printf('<td> %s </td>',$column_value);
			}unset($column_name); unset($column_value);
			printf('</tr>');
		}
		
		printf('</tbody></table></div>');
	}

	public function renderViewEmployeeButton(){
		printf('<div id="viewEmp" class="viewEmpButton"><a href="#employeeForm">Посмотреть карточку сотрудника</a></div>');
	}	
	
	public function renderUpdateEmployeeButton(){
		printf('<div id="updateEmp" class="viewEmpButton"><a href="#employeeForm">Редактировать карточку сотрудника</a></div>');
	}	
	
	public function renderAddEmployeeButton(){
		printf('<div id="addEmp" class="viewEmpButton"><a href="#employeeForm">Добавить нового сотрудника</a></div>');
	}	
	
	public function renderDelEmployeeButton(){
		printf('<div id="delEmp" class="viewEmpButton"><a href="#employeeForm">Удалить сотрудника</a></div>');
	}
	
	public function renderEmployeeForm(){
		printf('<div id="employeeForm" class="hide"><div>
				<form>
					<h2>Карточка сотрудника</h2>
					<table>
					<thead>
						<tr><th>Параметр</th><th>Значение</th></tr>
					</thead>
					<tbody>
						<tr style="display: none;"><td>id</td><td><input disabled name="id" type="text" /></td></tr>
						<tr><td>Фамилия</td><td><input disabled name="family_name" type="text" placeholder="Фамилия" /></td></tr>
						<tr><td>Имя</td><td><input disabled name="name" type="text" placeholder="Имя" /></td></tr>
						<tr><td>Отчество</td><td><input disabled name="second_name" placeholder="Отчество" type="text" /></td></tr>
						<tr><td>Пол</td><td><input disabled name="sex" type="text" placeholder="м\ж" /></td></tr>
						<tr><td>Дата рождения</td><td><input disabled name="birth_date" type="text" placeholder="1900-01-01" /></td></tr>
					</tbody>
					</table>
						
					<table id="work">
					<thead>
						<input  name="addWorkPlace" type="button" value="Добавить место работы"/>
						<tr><th>id</th><th plus>Место работы</th><th>Дата начала работы</th><th>Дата конца работы</th></tr>
					</thead>
					<tbody>
					</tbody>
					</table>
					<input type="text" name="data" value="" style="display: none;" />
				</form>
					<input name="delete"  type="button" value="Удалить" />
					<input name="save"  type="button" value="Сохранить" />
					<input name="reset"  type="button" value="Сбросить" />
					<input name="close"  type="button" value="Закрыть" />
				</div></div>');
	}
	
	public function renderMessageBox(){
		printf('<div id="messageBox" class="hide"><div><h3>Внимание!</h3><p></p></div></div>');
	}
	
}
?>