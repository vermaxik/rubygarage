<?php
require_once('auth.php');
if($tm->checkCookie() == "0") { header("Location:/?access=3"); exit(); }
?>

<!DOCTYPE html>
<head>
	<title>RubyGarage</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">	
    <style>
    body {
     margin: 0;
     background-image: url('img/background_in.jpg');
     background-size: 1920px 1200px;
     background-position: top center;
     background-repeat:no-repeat;
     background-color:#0470DD;
     background-attachment:fixed;
     display: compact;
    }
    </style>
    <script>
        $(document).ready(function(){
               
            $("#project_add_form").hide();
            $("#project_add").show();
            $('#project_add').click(function(){
                $("#project_add_form").slideToggle();
            });
            
            
         $('#exit').click(function(){
            
				$.ajax({
					type: "POST",
					url: "auth.php",
					data: "exit=true",
					success: function(html){
						$(".row").html(html);
				   }
				});
                return false;
			});
         
        $('#list_add').click(function(){
    		$.ajax({
    			type: "POST",
    			url: "task_list.php",
    			data: "list_name="+$("#name_list").val(),
    			success: function(html){
    				$(".row").html(html);
    		   }
    		});
            $("#name_list").val('');
            return false;
    	});
           
        });
        

    </script>	
</head>
<body>

<div class="row" style="margin-top: 35px;">
	<?php require_once('task_list.php');?>    
 </div>
<center>
    <div style="display: none;margin-bottom:10px;" id="project_add_form">
        <div class="form-inline">
            <form id="list_form">
            <input type="text" id="name_list" placeholder="Please, insert List NAME" class="input-xlarge"> <input type="submit" value="+" id="list_add" class="btn btn-primary" />
            </form>
        </div>
    </div>
    <a  id="project_add" class="btn btn-large btn-primary" ><i class="icon-plus icon-white"></i> ADD TODO List</a>
    <br /><br /><br /><br />
    <a  id="exit" class="btn btn-mini btn-inverse" ><i class="icon-hand-left icon-white"></i> EXIT</a>
</center>


</body>
</html>