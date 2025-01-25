( function(buttonId, sourceTableBlockId, formId, workTableId,  pathToPHPScriptBoxId, responceMessageBoxId, closeHelper, showEmpOldData) {
/*
	Параметры блоков страницы для подключения модуля добавления карточки сотрудника
buttonId -- имя ссылки блока при нажатии которой открываю форму для просмотра карточки
sourceTableBlockId --id блока содержащего таблицу, с выделенной строкой сотрудника
formId -- id блока для просмотра карточки сотрудника
workTableId -- id таблицы с данными о рабочих местах сотрудника
pathToPHPScriptBoxId -- id блока в котором записан адрес php сценария который запускаем при открытии формы
responceMessageBoxId -- id блока который показывает надпись о результате отправки сообщения
*/



//добавляем слушатель на событие нажатие кнопки добавить карточку сотрудника
document.querySelector("#"+buttonId+"").onclick=updateEmp;

//задаем переменные
var formId = formId;
var workTableId = workTableId;
var pathToPHPScriptBoxId = pathToPHPScriptBoxId;
var responceMessageBoxId = responceMessageBoxId;
var closeHelper = closeHelper;
var showEmpOldData = showEmpOldData;


//определяем функцию для просмотра карточки запросом ajax
function updateEmp(){
	 
	var targetForm = $("#"+formId);
	var targetTable = $('#'+sourceTableBlockId + " table");
	var pathToScenarijPHP=document.querySelector("#"+pathToPHPScriptBoxId).innerText;	
	var targetResponceMessageBox= "#" +responceMessageBoxId;

	//получаем данные от сотрудника
	window.isEmpNotSelected = 1; 
	showEmpOldData();
	
	setTimeout(function(){ //даем время вызванному блоку отработать перед запуском основного кода
	
		if(window.isEmpNotSelected) {  
			return; 
		}
		
		//подготавливаем форму
		$("#"+formId+" input[name=family_name]").removeAttr('disabled');
		$("#"+formId+" input[name=name]").removeAttr('disabled');
		$("#"+formId+" input[name=second_name]").removeAttr('disabled');
		$("#"+formId+" input[name=sex]").removeAttr('disabled');
		$("#"+formId+" input[name=birth_date]").removeAttr('disabled');
		$("#work tbody tr td input").removeAttr('disabled');

		$("#"+formId+" input[name=delete]").addClass('hide');
		$("#employeeForm input[name=save]").removeClass('hide'); 	
		$("#"+formId+" input[name=reset]").removeClass('hide');   
		$("#"+formId+" input[name=addWorkPlace]").removeClass('hide');

		$("#"+formId).append('<input type="text" name="work_places" style="display: none" />');
		
		//добавляем слушателей на кнопки формы
		document.querySelector("#"+formId+" input[name=addWorkPlace]").onclick=addNewRow;
		function addNewRow(){
			$("#"+workTableId).append('<tr><td><input name="work_id" type="text" />'+
									  '</td><td><input name="company_name" type="text" />'+
									  '</td><td><input name="work_start" type="text" />'+
									  '</td><td><input name="work_end" type="text" />'+'</td></tr>');
		}
		
		
		document.querySelector("#"+formId+" input[name=reset]").onclick=resetForm;
		function resetForm(){
			//очищаем поля первой таблицы
			$("input[name=family_name]").val('');
			$("input[name=name]").val('');
			$("input[name=second_name]").val('');
			$("input[name=sex]").val('');
			$("input[name=birth_date]").val('');
			
			$("input[name=family_name]").removeAttr('value');
			$("input[name=name]").removeAttr('value');
			$("input[name=second_name]").removeAttr('value');
			$("input[name=sex]").removeAttr('value');
			$("input[name=birth_date]").removeAttr('value');
			
			//очищаем вторую таблицу
			$("#"+formId+" #"+workTableId+ " tbody tr").remove();
			$("#"+formId+" input[name=data]").val('');
		}
		
		
		
		
		document.querySelector("#"+formId+" input[name=save]").onclick=sendAjax1;
		function sendAjax1()
		{
		
		//для каждой строки делаю функцию которая пишет строку в массив как имя input и его значение 
			var work_massiv = [];
			var i=0;
			var id = $("#"+formId+" input[name=id]").val();
			var family_name = $("#"+formId+" input[name=family_name]").val();
			var name = $("#"+formId+" input[name=name]").val();
			var second_name = $("#"+formId+" input[name=second_name]").val();
			var sex = $("#"+formId+" input[name=sex]").val();
			var birth_date = $("#"+formId+" input[name=birth_date]").val();
			var dataToSend = {};
			var form_object= new FormData();
			 
			$("#work tbody tr").each(function(){ 
												work_massiv[i]={};
												$(this).find('td input').each(function(){ 

															switch($(this).attr('name')){
																case 'work_id': work_massiv[i].work_id =$(this).val(); break;
																case 'company_name': work_massiv[i].company_name = $(this).val(); break;
																case 'work_start': work_massiv[i].work_start = $(this).val(); break;
																case 'work_end': work_massiv[i].work_end = $(this).val(); break;
																default: break;
															}

														}); 
												i=i+1;
												});
			
			//заполняем данные для отправки
			dataToSend.id = id;
			dataToSend.family_name = family_name;
			dataToSend.name = name;
			dataToSend.second_name = second_name;
			dataToSend.sex = sex;
			dataToSend.birth_date = birth_date;
			dataToSend.workPlaces = work_massiv;
			
			dataToSend = JSON.stringify(dataToSend);
			
			//console.log('SENDING________________');
			//console.log(dataToSend);
			//console.log('SENDING END________________');
			
			$("#"+formId+" input[name=data]").val(dataToSend);
			
			//помещаем данные в объект для отправки
			form_object.append('asck_for_action', 'update_emp');
			form_object.append('data', $("#"+formId+" input[name=data]").val());
			
			
			//отправляем запрос
			$.ajax({
				async:  true,
				contentType: false,		
				data: form_object,
				dataType: "text",		
				processData: false,		
				type: "POST",
				url: pathToScenarijPHP,
				beforeSend: checkForm,	
				success: callbackFunctionShowEmp,  	
				error: errorFunction
				//complete: 	infoFunction('Сотрудник добавлен!', 'succes')	
				});
			
			
			function checkForm(xhr, opts)
			{
					if(family_name == undefined || family_name ==""){ xhr.abort(); infoFunction('Ошибка заполните поле фамилия!', 'error'); }
				else 
					if(name == undefined || name ==""){ xhr.abort(); infoFunction('Ошибка заполните поле имя!', 'error'); }
				else
					if(second_name == undefined || second_name ==""){ xhr.abort(); infoFunction('Ошибка заполните поле отчество!', 'error'); }
				else
					if(sex == undefined || sex ==""){ xhr.abort(); infoFunction('Ошибка заполните поле пол!', 'error'); }
				else
					if(birth_date == undefined || birth_date ==""){ xhr.abort(); infoFunction('Ошибка заполните поле дата рожденния!', 'error'); }	
			
			}
			
			function callbackFunctionShowEmp(data_returned)	
			{
				console.log(data_returned);
				var resultsMassiv=JSON.parse(data_returned); 
				console.log(resultsMassiv);
				
				
				
				if(resultsMassiv.response != 'OK') {
					infoFunction('Ошибка не удалось обновить сотрудника!', 'error');
				}
				else{
						infoFunction('Данные сотрудника обновлены!', 'success');
						setTimeout(function(){location.reload();},2020);
						closeHelper();
				}
				
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
				$(targetResponceMessageBox+' p').text('Ошибка не удалось обновить сотрудника!');
				
				displayMessageFunction();
			}

	},100); //end setTimeout for all after showEmpOldData to give it time for complete

}

})("updateEmp", "mainTable", "employeeForm", "work", "ajax", "messageBox", window.closeHelper, window.showEmpOldData);

console.log("add emp modul start");