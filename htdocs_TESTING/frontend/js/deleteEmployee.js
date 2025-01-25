( function(buttonId, sourceTableBlockId, formId,  pathToPHPScriptBoxId, responceMessageBoxId) {
/*
	Параметры блоков страницы для подключения модуля удаления сотрудника
buttonId -- имя ссылки блока при нажатии которой открываю форму для удаления
sourceTableBlockId --id блока содержащего таблицу, с выделенной строкой сотрудника
formId -- id блока для просмотра карточки сотрудника
pathToPHPScriptBoxId -- id блока в котором записан адрес php сценария который запускаем при открытии формы
responceMessageBoxId -- id блока который показывает надпись о результате отправки сообщения
*/



//добавляем слушатель на событие нажатие кнопки показать карточку сотрудника
document.querySelector("#"+buttonId+"").onclick=delEmp;

//задаем переменные
var targetForm = $("#"+formId);
var targetTable = $('#'+sourceTableBlockId + " table");
var pathToScenarijPHP=document.querySelector("#"+pathToPHPScriptBoxId).innerText;	
var targetResponceMessageBox= "#" +responceMessageBoxId;

//определяем функцию для просмотра карточки запросом ajax
function delEmp(){

	var employeeId = 0;
	
	
	//определяет выделена ли строка
	if(targetTable.find('tr[marked]').length){
		employeeId = targetTable.find('tr[marked]').children()[0].innerText;
	}
	
	var data = {asck_for_action: 'del_emp', id: employeeId};
	$.post(pathToScenarijPHP, data, callbackFunctionDelEmp).fail(function(){ errorFunction('Ошибка не удалось удалить сотрудника!'); });

		function callbackFunctionDelEmp(data_returned)	
		{
			
			console.log(data_returned);
			
			var resultsMassiv=JSON.parse(data_returned); 
			
			console.log(resultsMassiv);
			
			if(resultsMassiv.response != 'OK') {
				errorFunction();
			}
			else{
					infoFunction('Сотрудник успешно удален!');
					setTimeout(function(){location.reload();},2020);
			}
							
		}


		function displayMessageFunction()
		{ 
			$(targetResponceMessageBox).removeClass('hide').addClass('show');  
			setTimeout(function(){$(targetResponceMessageBox).removeClass('show').addClass('hide')},2000);		
			setTimeout(function(){$(targetResponceMessageBox+" p").css('color','grey'); $(targetResponceMessageBox+ " p").text("");},2010);	
		}

		function errorFunction()
		{	
			$(targetResponceMessageBox+" p").css('color', 'red');
			$(targetResponceMessageBox+' p').text('Ошибка не удалось удалить сотрудника!');
			
			displayMessageFunction();
		}
		
		function infoFunction($msg='')
		{	
			$(targetResponceMessageBox+" p").css('color', 'green');
			$(targetResponceMessageBox+' p').text($msg);
			
			displayMessageFunction();
		}
		
}

})("delEmp", "mainTable", "employeeForm", "ajax", "messageBox");

console.log("del emp modul start");