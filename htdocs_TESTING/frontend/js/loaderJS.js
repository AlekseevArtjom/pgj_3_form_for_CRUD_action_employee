function load_module(src)
{
var script_to_load = document.createElement('script');
script_to_load.src = src;
script_to_load.type="module";
script_to_load.async = false ;
document.body.append(script_to_load);
}





window.addEventListener('load', function ()
{
console.log("start loading js");
load_module("/frontend/js/jquery-3.6.0.js");
load_module("/frontend/js/SelectRow.js");
load_module("/frontend/js/closeForm.js");
load_module("/frontend/js/viewEmployee.js");
load_module("/frontend/js/deleteEmployee.js");  

load_module("/frontend/js/addEmployee.js");
load_module("/frontend/js/updateEmployee.js");



});
