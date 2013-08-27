$(document).ready(function(){
 
    $('#singup').click(function(){
        
        var login = $('#log').val(); 
        var password = $('#pass').val(); 

        if(!login.length) { 
            $("#log").addClass('error').attr("placeholder", "Please input LOGIN or SING IN");
        } else {$("#log").removeClass('error');}
        
        if(!password.length) { 
            $("#pass").addClass('error').attr("placeholder", "Please input PASSWORD");
        } else {$("#pass").removeClass('error');}
        
        if(login.length && password.length) {
            
            $.ajax({
					type: "POST",
					url: "/auth.php",
					data: "singup=1&login="+login+"&passwd="+password,
					success: function(html){
						$("#login").html(html);
				   }
				});

        }
    });
    
     
    $('#singin').click(function(){   
        
       $('#login').animate({width: 200, height: 200, left: -100, top: -100}, 500);
        $('#register').show('slow');
        $("#log").removeClass('error').attr("placeholder", "Login");
        $("#pass").removeClass('error').attr("placeholder", "Password");
    });
    
    
    $('#cancel').click(function(){  
        $('#register').hide();
        $('#login').show().animate({width: 200, height: 200, left: $(window).width()/2, top: $(window).height()/2}, 500);;
    });
    
    
    $('#regin').click(function(){
        
        var name = $('#r_name').val(); 
        var login = $('#r_log').val(); 
        var password = $('#r_pass').val(); 

        if(!name.length) { 
            $("#r_name").addClass('error').attr("placeholder", "Please input NAME");
        } else {$("#r_name").removeClass('error');}
        
        if(!login.length) { 
            $("#r_log").addClass('error').attr("placeholder", "Please input LOGIN");
        } else {$("#r_log").removeClass('error');}
        
        if(!password.length) { 
            $("#r_pass").addClass('error').attr("placeholder", "Please input PASSWORD");
        } else {$("#r_pass").removeClass('error');}
        
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

});