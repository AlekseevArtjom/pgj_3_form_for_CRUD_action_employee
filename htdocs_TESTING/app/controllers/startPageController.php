<?php

namespace test\app\controllers;

use test\app\controllers\baseController;
use test\app\models\mainTableModel;
use test\app\views\startPageView;

class startPageController extends baseController 
{
	
	public function __construct(){ parent::__construct(); 
	}
	
	public function getConf(){
		echo '</br><pre>';
		echo '</br>'; var_dump($this->model_config); 
		echo '</br>'; var_dump($this->view_config); 
		echo '</pre>';
	}
	
	//create main page
	public function makeMainPage(){
		$data_model = new mainTableModel($this->main_config, $this->model_config);
		$data_main_table = $data_model->getMainTable();
		
		$startPageView = new startPageView($this->main_config, $this->view_config, $data_main_table);
		require_once('startPageTemplate.html');
		
	}
	
	
}














?>