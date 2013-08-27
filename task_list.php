<?php
require_once('auth.php');
if($tm->checkCookie() == "0") { header("Location:/?access=3"); exit(); }
require_once("task_manager.class.php");

$tm = new Task_manager();
$tm->db(); // подключаемся к базе

if($_POST['edit_project'] && !empty($_POST['edit_project']) && !empty($_POST['name_project'])) {
    $ui = $tm->checkCookie();
    $project_id = intval($_POST['edit_project']);
    $tm->editProject($project_id, $_POST['name_project'], $ui['project_id']);
}

if($_POST['edit_task'] && !empty($_POST['edit_task']) && !empty($_POST['name_task'])) {
    $task_id = intval($_POST['edit_task']);
    $tm->editTask($task_id, $_POST['name_task']);
}

if($_POST['list_name'] && !empty($_POST['list_name'])) {
    $ui = $tm->checkCookie();
    $tm->addProject($_POST['list_name'], $ui['project_id']); 
    
}
if($_POST['project_id'] && !empty($_POST['project_id']) && !empty($_POST['task_name'])) {
    
    $tm->addTask($_POST['project_id'], $_POST['task_name']); 
    
}

if($_POST['task_status']  && !empty($_POST['task_status']) ) {
    $task_id = intval($_POST['task_status']);
    $tm->setTaskStatus($task_id);
}

if($_POST['task_del']  && !empty($_POST['task_del']) ) {
    $task_id = intval($_POST['task_del']);
    $tm->delTask($task_id);
}


if($_POST['delete_project']  && !empty($_POST['delete_project']) ) {
    $ui = $tm->checkCookie();
    $project_id = intval($_POST['delete_project']);
    if(in_array($project_id, $ui['project_id'])) { // данный пользователь удалять свой проект?
        $tm->delProject($project_id);
    }
    
}
$ui = $tm->checkCookie();
$tl = $tm->getTaskList($ui['project_id']); // получаем список проектов 


?>
<?php //echo "<pre>"; print_r($tl); echo "</pre>";?>

<div class="span3">&nbsp;</div>
<div class="span8">
    <center><h2><font color="#fff"><?=$ui['user_info']['user_name']?>'s SIMPLE TODO LIST</font></h2></center>
    <?php if( !empty ($tl)): ?>
    <?php foreach($tl as $project_id => $projects): ?>
    <?php foreach($projects as $project => $tasks): ?>
<table class="table  table-striped table-bordered" width="100%">
        <tr>
            <td colspan="4" class="project">

                <b><?=$project?></b>
                <div class="project_del" style="float:right;visibility:hidden;">
                    <img src="img/b_edit.gif" class="project_edit" id="<?=$project_id?>" style="cursor: pointer;" title="Edit project <?=$project?>"  /> 
                    &nbsp;&nbsp;
                    <img src="img/b_del.gif" class="project_delete" id="<?=$project_id?>" style="cursor: pointer;" title="Delete project <?=$project?>" />
                    </div>
            </td>
        </tr>
        <tr>
            <td colspan="4" align="right">
                <form id="task_form" >
                <div class="form-inline" style="float: right;">
                    <i class="icon-plus icon-white"></i> <input name="task_name" type="text" id="task_name" placeholder="Please, insert TASK NAME" class="input-xxlarge" style="width:620px;"> <input type="submit" value="ADD TASK" id="task_add" class="btn btn-primary" />
                </div>
                <input type="hidden" value="<?=$tasks[0]['project_id']?>" id="project_id" name="project_id" />
                </form>
            </td>
        </tr>
        <?php foreach($tasks as $task): ?>
            <?php if($task['task_name']): ?>
            	<tr style="background-color:#fff;" >
            		<td width="15"><input type="checkbox" class="status" id="<?=$task['task_id']?>" <?php if($task['status']=="1") echo 'checked="1"'; ?> /></td>
            		<td class="ed_task">
                        <?php if($task['status']=="1"): ?>
                            <s><?=$task['task_name']?></s>
                        <?php else: ?>
                            <i id="iname"><?=$task['task_name']?></i>
                        <?php endif; ?>
                    <div class="form-inline" style="float: right;">
                        <button class="btn btn-mini btn-success editTask" id="<?=$task['task_id']?>"><i class="icon-edit icon-white"></i></button> <button class="btn btn-mini btn-danger delTask" id="<?=$task['task_id']?>"><i class="icon-remove-sign icon-white"></i></button></td>
                    </div>
            	</tr>
             <?php endif; ?>
        <?php endforeach; ?>
</table>
    <?php endforeach; ?>
    <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php // echo "<pre>". count($_POST)."</pre>";?>
<script>
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

$(".editTask").one("click", function() {
    var ID = $(this).attr('id'); 
    var task_name = $(this).closest('.ed_task').find('#iname').html();
    $(this).closest('.ed_task').find('#iname').html("<div class='form-inline' style='float:left;'><input type='text'  value='"+task_name+"' id='new_task_name'> <input type='submit' value='SAVE' class='btn btn-info' id='task_save'/></div>");
    
    $(this).closest('.ed_task').find('#task_save').click(function() {
        var task_edit = $(this).closest('.ed_task').find('#new_task_name').val();
            $.ajax({
    		type: "POST",
    		url: "task_list.php",
    		data: "edit_task="+ID+"&name_task="+task_edit,
    		success: function(html){
    			$(".row").html(html);
    	   }
    	});
    	return false;
     });
    $(this).closest('.ed_task').find('#new_task_name').keyup(function(event){
        if(event.keyCode == 13){
            $(this).closest('.ed_task').find('#task_save').click();
         }
     });
});

$(".project_edit").one("click", function() {
    var ID = $(this).attr('id');
    var project_name = $(this).closest('.project').find('b').html();
    $(this).closest('.project').find('b').html("<div class='form-inline' style='float:left;'><input type='text'  value='"+project_name+"' id='new_project_name'> <input type='submit' value='SAVE' class='btn btn-inverse' id='project_save'/></div>");
    $(this).closest('.project').find('#project_save').click(function() {
        var project_edit = $(this).closest('.project').find('#new_project_name').val();
            $.ajax({
    		type: "POST",
    		url: "task_list.php",
    		data: "edit_project="+ID+"&name_project="+project_edit,
    		success: function(html){
    			$(".row").html(html);
    	   }
    	});
    	return false;
     });
    $(this).closest('.project').find('#new_project_name').keyup(function(event){
        if(event.keyCode == 13){
            $(this).closest('.project').find('#project_save').click();
         }
     });
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
</script>
