



<?php
require_once("../resource/config.php");

$msg='';
if($_SERVER["REQUEST_METHOD"] == "POST")
{
$recaptcha=$_POST['g-recaptcha-response'];
if(!empty($recaptcha))
{
include("getCurlData.php");
$google_url="https://www.google.com/recaptcha/api/siteverify";
$secret='6Lfrvx8TAAAAAKtscMiMOTaDAe7Ni5Pzn1FxBQ2s';
$ip=$_SERVER['REMOTE_ADDR'];
$url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
$res=getCurlData($url);
$res= json_decode($res, true);
if($res['success'])
{

/********/
$username=mysqli_real_escape_string($db,$_POST['username']); 
$password=md5(mysqli_real_escape_string($db,$_POST['password'])); 
if(!empty($username) && !empty($password))
{

$result=mysqli_query($db,"SELECT id FROM users WHERE username='$username' and passcode='$password'");
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
if(mysqli_num_rows($result)==1)
{
$_SESSION['login_user']=$username;
header ("location: ../public/index1.php");
}
else
{
$msg="Please give valid Username or Password.";
}

}
else
{
$msg="Please give valid Username or Password.";
}
/********/
}
else
{
redirect("index1.php");
}

}
else
{
redirect("index1.php");
}

}
?>



<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>SmileOnut Log In</title>
<link rel="stylesheet" href="css/style.css"/>
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
<div id="main">
<h1>log in</h1>
<div id="box">
<form action="" method="post">
<label>Username</label> <input type="text" name="username" class="input" />
<label>Password </label><input type="password" name="password" class="input" />
<br/><br/>
<div class="g-recaptcha" data-sitekey="6Lfrvx8TAAAAAKge9wjRiDn8PJZdTBZ8nGi3lxqp"></div>
<br/>
<input type="submit" class="button button-primary" value="Log In" id="login"/> 

<span class='msg'><?php echo $msg; ?></span>
</form>
</div>



</body>
</html>


<p> Don't have an account? <h2>Sign Up <span class="glyphicon glyphicon-hand-right"></span></h2><a href="registration.php">Sign up</a></p>

<div class="col-sm-2">






<?php include(TEMPLATE_FRONT . DS ."footer.php");?>
    
