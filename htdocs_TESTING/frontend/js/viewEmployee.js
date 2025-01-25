window.showEmpOldData=
( function(buttonId, sourceTableBlockId, formId, workTableId,  pathToPHPScriptBoxId, responceMessageBoxId) {
/*
	Параметры блоков страницы для подключения модуля просмотра каарточки сотрудника
buttonId -- имя ссылки блока при нажатии которой открываю форму для просмотра карточки
sourceTableBlockId --id блока содержащего таблицу, с выделенной строкой сотрудника
formId -- id блока для просмотра карточки сотрудника
workTableId -- id таблицы с данными о рабочих местах сотрудника
pathToPHPScriptBoxId -- id блока в котором записан адрес php сценария который запускаем при открытии формы
responceMessageBoxId -- id блока который показывает надпись о результате отправки сообщения
*/



//добавляем слушатель на событие нажатие кнопки показать карточку сотрудника
document.querySelector("#"+buttonId+"").onclick=ShowEmp;

var formId = formId;
var workTableId = workTableId;
var pathToPHPScriptBoxId = pathToPHPScriptBoxId;
var responceMessageBoxId = responceMessageBoxId;

//определяем функцию для просмотра карточки запросом ajax
function ShowEmp(){
	
	//задаем переменные
	var targetForm = $("#"+formId);
	var targetTable = $('#'+sourceTableBlockId + " table");
	var pathToScenarijPHP=document.querySelector("#"+pathToPHPScriptBoxId).innerText;	
	var targetResponceMessageBox= "#" +responceMessageBoxId;
	var employeeId = 0;
	var form_object= new FormData();
	
	//определяет выделена ли строка
	if(targetTable.find('tr[marked]').length ){
		employeeId = targetTable.find('tr[marked]').children()[0].innerText;
	}
	
	
	if(employeeId == 0) { 
		infoFunction('Ошибка сотрудник не выбран!', 'error'); 
		window.isEmpNotSelected = 1; 
		//console.log('window.isEmpNotSelected='+window.isEmpNotSelected);
		return; 
	}
	else {
		window.isEmpNotSelected = 0;
	}
	
	//заполняем объект для отправки
	form_object.append('asck_for_action', 'show_emp');
	form_object.append('id', employeeId);
		
		$.ajax({
			async:  true,
			contentType: false,		
			data: form_object,
			dataType: "text",		
			processData: false,		
			type: "POST",
			url: pathToScenarijPHP,
			//beforeSend: checkForm,	
			success: callbackFunctionShowEmp,  
			error: errorFunction
			//complete: 	displayMessageFunction	//по окончанию запроса
			});


		function callbackFunctionShowEmp(data_returned)	
		{
	
			var resultsMassiv=JSON.parse(data_returned); 
			
			if(resultsMassiv === null) {
				infoFunction('Ошибка карточка не найдена!', 'error');
				
			}
			else{ 
				
				if(resultsMassiv.response == 'err') { infoFunction('Ошибка сервера код 500!', 'error'); return; }
				
				$("#"+formId+" input[name=id]").val(resultsMassiv[0].id);
				$("#"+formId+" input[name=family_name]").val(resultsMassiv[0].family_name);  
				$("#"+formId+" input[name=name]").val(resultsMassiv[0].name);
				$("#"+formId+" input[name=second_name]").val(resultsMassiv[0].second_name);
				$("#"+formId+" input[name=sex]").val(resultsMassiv[0].sex);
				$("#"+formId+" input[name=birth_date]").val(resultsMassiv[0].birth_date);

				for(var i=0; i<resultsMassiv.length; i++){
					if(resultsMassiv[i].work_id != null)
					$("#"+workTableId).append('<tr><td><input disabled name="work_id" type="text" value="'+$.trim(resultsMassiv[i].work_id)+'" />'+
											 '</td><td><input disabled name="company_name" type="text" value ="'+$.trim(resultsMassiv[i].company_name)+'" />'+
											 '</td><td><input disabled name="work_start" type="text"  value ="'+$.trim(resultsMassiv[i].work_start)+'"/>'+
											 '</td><td><input disabled name="work_end" type="text" value="'+$.trim(resultsMassiv[i].work_end)+'" /></td></tr>');
					
				}
				
				$("#"+formId+" input[name=delete]").addClass('hide');
				$("#"+formId+" input[name=save]").addClass('hide');
				$("#"+formId+" input[name=reset]").addClass('hide');
				$("#"+formId+" input[name=addWorkPlace]").addClass('hide');
				
				targetForm.removeClass('hide');
			}
			
			
		}


		function displayMessageFunction()
		{ 
			$(targetResponceMessageBox).removeClass('hide').addClass('show');  
			setTimeout(function(){$(targetResponceMessageBox).removeClass('show').addClass('hide')},2000);		
			setTimeout(function(){$(targetResponceMessageBox+" p").css('color','grey'); $(targetResponceMessageBox+ " p").text("");},2010);	
		}
		
		
		function infoFunction(msg, type = 'error')
		{
			var color;
			
			if(type == 'error') color = 'red';
			else if(type == 'success') color = 'green';	
			else color = 'black';
			
			$(targetResponceMessageBox+" p").css('color',color);
			$(targetResponceMessageBox+' p').text(msg);
			
			displayMessageFunction();
		}

		function errorFunction()
		{

			$(targetResponceMessageBox+" p").css('color','red');
			$(targetResponceMessageBox+' p').text('Ошибка карточка не найдена!');
			
			displayMessageFunction();
		}
		
}
return ShowEmp;

}("viewEmp", "mainTable", "employeeForm", "work", "ajax", "messageBox"));

console.log("show emp modul start");