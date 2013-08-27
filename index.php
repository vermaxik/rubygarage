<?php
require_once('auth.php');
//print_r($tm->checkCookie());
$auth = $tm->checkCookie();
if($auth !== 0) {  // прошли авторизацию
     header("Location:/task_manager.php"); 
}
?>

<!DOCTYPE html>
<head>
	<title>RubyGarage</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/screen.css">		
    <script type="text/javascript" src="/js/login.js"></script>
</head>
<body>

<div  id="login">
  <img src="/img/ruby_logo.png"> <br /><br />
  <div class="row " align="center">
    <?php if($_GET['access'] == "1") : ?>
        Thank you for Your Registration :) <br/> Please SING IN.<br/>
    <?php elseif($_GET['access'] == "2") : ?>
        Sorry, access denied.<br/> Check your credential.<br/>
    <?php elseif($_GET['access'] == "3") : ?>
        Session end.<br/> Check your credential.<br/>
    <?php endif; ?>
    <input type="text" placeholder="Login" id="log"  /> <br />
    <input type="password" placeholder="Password" id="pass" /> <br />
    <input type="submit" value="SING IN" id="singup" class="btn btn-primary" />
    or <input type="submit" value="SING UP" id="singin" class="btn btn-inverse" />
  </div>
</div>

<div  id="register" style="display: none;" >
    <div class="row " align="center">
    <strong><h3>REGISTER FORM</h3></strong>
    <input type="text" placeholder="Your Name" id="r_name"  maxlength="20" required /> <br />
    <input type="text" placeholder="Login" id="r_log"  maxlength="12" required /> <br />
    <input type="password" placeholder="Password" id="r_pass"  maxlength="30" required  /> <br />
    <input type="submit" value="REGISTER" id="regin" class="btn btn-primary" />
    or <input type="submit" value="CANCEL" id="cancel" class="btn " />
    </div>
</div>


</body>
</html>