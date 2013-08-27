<?php

require_once("task_manager.class.php");

$tm = new Task_manager();
$tm->db(); // подключаемся к базе

if($_POST['exit']=="true")  {
    $tm->destroyCookie();
    echo '<script>window.location.replace("'.$tm->base_domain.'/");</script>';
}
elseif($_POST['register']=="1" && !empty($_POST['name']) && !empty($_POST['login']) && !empty($_POST['passwd'])){
    $return = $tm->addUser($_POST['name'], $_POST['login'], $_POST['passwd']);
    switch($return) {
        case "1": 
            echo '<script>window.location.replace("'.$tm->base_domain.'/?access=1");</script>';
        break;  
            
        case "2" :
            echo '
                <div class="row " align="center">
                <strong><h3>REGISTER FORM</h3></strong>
                Sorry, but Login is exist!<br/>
                <input type="text" value="'.$_POST['name'].'" placeholder="Your Name" id="r_name"  maxlength="20" required /> <br />
                <input type="text" placeholder="Login" id="r_log"  maxlength="12" required /> <br />
                <input type="password" placeholder="Password" id="r_pass"  maxlength="30" required  /> <br />
                <input type="submit" value="REGISTER" id="regin" class="btn btn-primary" />
                or <input type="submit" value="CANCEL" id="cancel" class="btn " />
                </div>
            ';
            
            echo '
                <script>
                $("#regin").click(function(){
        
                var name = $("#r_name").val(); 
                var login = $("#r_log").val(); 
                var password = $("#r_pass").val(); 
        
                if(!name.length) { 
                    $("#r_name").addClass("error").attr("placeholder", "Please input NAME");
                } else {$("#r_name").removeClass("error");}
                
                if(!login.length) { 
                    $("#r_log").addClass("error").attr("placeholder", "Please input LOGIN");
                } else {$("#r_log").removeClass("error");}
                
                if(!password.length) { 
                    $("#r_pass").addClass("error").attr("placeholder", "Please input PASSWORD");
                } else {$("#r_pass").removeClass("error");}
                
                if(name.length && login.length && password.length) {
                
                    $.ajax({
        					type: "POST",
        					url: "/auth.php",
        					data: "register=1&name="+name+"&login="+login+"&passwd="+password,
        					success: function(html){
        						$("#register").html(html);
        				   }
        				});
                    }
                });
                
                $("#cancel").click(function(){  
                    $("#register").hide();
                    $("#login").show().animate({width: 200, height: 200, left: $(window).width()/2, top: $(window).height()/2}, 500);;
                });
            </script>
            ';
        break;
        
        case "0" :
            echo "Sorry, mysql error";
        break;
    }
  
}


elseif($_POST['singup']=="1" && !empty($_POST['login']) && !empty($_POST['passwd'])){

    $return = $tm->checkUser($_POST['login'], $_POST['passwd']); 
    switch($return) {
        case "1":
            $tm->checkCookie($_POST['login'], $_POST['passwd']); 
            echo '<script>window.location.replace("'.$tm->base_domain.'/task_manager.php");</script>'; 
        break;
        case "0": 
            echo '<script>window.location.replace("'.$tm->base_domain.'/?access=2");</script>';
        break;  
    } 
} 
 //echo $tm->checkCookie();

?>


