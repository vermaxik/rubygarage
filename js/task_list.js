$(document).ready(function(){
    
    
$('form').submit(function(){

                var str = $(this).serialize();
				$.ajax({
					type: "POST",
					url: "task_list.php",
					data: str,
					success: function(html){
						$(".row").html(html);
				   }
				});
				return false;
			}); 

$(".project").mouseenter(function () {
    $(this).find(".project_del").css("visibility","visible");
}).mouseleave(function () {
    $(this).find(".project_del").css("visibility","hidden");
});
$(".project_delete").click(function(){
    var ID = $(this).attr('id');
    $.ajax({
		type: "POST",
		url: "task_list.php",
		data: "delete_project="+ID,
		success: function(html){
			$(".row").html(html);
	   }
	});
	return false;
}); 

$(".project_edit").one("click", function() {
    var ID = $(this).attr('id');
    var project_name = $(this).closest('.project').find('b').html();
    $(this).closest('.project').find('b').html("<div class='form-inline' style='float:left;'><input type='text'  value='"+project_name+"'></div>");
});

$(".status").click(function(){
    var ID = $(this).attr('id');
    $.ajax({
		type: "POST",
		url: "task_list.php",
		data: "task_status="+ID,
		success: function(html){
			$(".row").html(html);
	   }
	});
	return false;
});

$(".delTask").click(function(){
    var ID = $(this).attr('id');
    $.ajax({
		type: "POST",
		url: "task_list.php",
		data: "task_del="+ID,
		success: function(html){
			$(".row").html(html);
	   }
	});
	return false;
 });  
});