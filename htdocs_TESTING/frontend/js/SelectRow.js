( function(tableId) {
/*
	Параметры блоков выделения строк по клику
tableId -- id таблицы в которой выделаем строки по клику

*/

//добавляем слушатель на событие нажатие кнопки показать карточку сотрудника
$("#"+tableId+" tr").click(function(){ selectRow($(this));});

//задаем переменные
var targetTable = $("#"+tableId);
var selected_color = 'rgba(100,130,150,0.9)'; //задаем цвет для выделенных строк

//определяем функцию для просмотра карточки запросом ajax
function selectRow(row){

	var old_color = row.css('background-color');
	
	//выделяет строку цветом если это не строка заголовка
	
	if (row.children()[0].innerText == 'id'){
			row.css('background-color', old_color);
			row.removeAttr('marked');
	}
	else{	row.nextAll().css('background-color', old_color);
			row.prevAll().css('background-color', old_color);
			row.css('background-color', selected_color);
			
			row.nextAll().removeAttr('marked');
			row.prevAll().removeAttr('marked');
			row.attr('marked', 'marked'); console.log(row.attr('marked'));
		}
		
	
	
		
}

})("mainTable");

console.log("select row modul start");