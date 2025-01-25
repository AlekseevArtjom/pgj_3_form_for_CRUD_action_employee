window.closeHelper=( function(buttonName, formId, workTableId, fieldName1, fieldName2, fieldName3, fieldName4, fieldName5) {
/*
	Параметры модуля для закрытия карточки сотрудника
buttonName -- имя кнопки для закрытия карточки сотрудника
formId -- id блока для просмотра карточки сотрудника
workTableId -- id таблицы с данными о рабочих местах сотрудника
fieldName1 -- имена полей для таблицы основных данных сотрудника
*/



//добавляем слушатель на событие нажатие кнопки показать карточку сотрудника
document.querySelector("input[name="+buttonName+"]").onclick=CloseEmpForm;

//задаем переменные
var targetForm = $("#"+formId);
var targetField1 = $("input[name="+fieldName1+"]");
var targetField2 = $("input[name="+fieldName2+"]");
var targetField3 = $("input[name="+fieldName3+"]");
var targetField4 = $("input[name="+fieldName4+"]");
var targetField5 = $("input[name="+fieldName5+"]");


//определяем функцию для очистки формы
function CloseEmpForm(){

	//console.log("close emp starts!");
	
	var tagretWorkTableTR = $("#"+formId+" #"+workTableId+ " tbody tr");
		
	//очищаем поля первой таблицы
	targetField1.val('');
	targetField2.val('');
	targetField3.val('');
	targetField4.val('');
	targetField5.val('');
	
	targetField1.removeAttr('value');
	targetField2.removeAttr('value');
	targetField3.removeAttr('value');
	targetField4.removeAttr('value');
	targetField5.removeAttr('value');
	
	//очищаем вторую таблицу
	tagretWorkTableTR.remove();
	$("#"+formId+" input[name=data]").val('');
	
	
	//скрываем лишний элемент управления
	$("#"+formId+" input[name=delete]").removeClass('hide');
	$("#"+formId+" input[name=addWorkPlace]").removeClass('hide');
	$("#"+formId+" input[name=save]").removeClass('hide');
	$("#"+formId+" input[name=reset]").removeClass('hide');
	
	
	//удаляем слушателей с кнопок
	document.querySelector("#"+formId+" input[name=addWorkPlace]").onclick=null;
	document.querySelector("#"+formId+" input[name=save]").onclick=null;
	document.querySelector("#"+formId+" input[name=reset]").onclick=null;
	document.querySelector("#"+formId+" input[name=reset]").onclick=null;
	
	//удаляем лишние поля
	$("#"+formId+" input[name=work_places]").remove();
		
	//закрываем форму
	targetForm.addClass('hide');
}
return CloseEmpForm;

})("close", "employeeForm", "work", "family_name", "name", "second_name", "sex", "birth_date");

console.log("close form modul start");