<?php 
ob_start();
require_once 'includes/config.php';
session_start();
$user_obj = new Cl_User();
// Cheak loginform validation
if(isset($_GET['success'])){
	if($_GET['success'] == 1){
$smsg = "Thank you for registeration! Please login.";
	}

}else{
	$smsg ="";
}

if( !empty( $_POST ))
{
	try
	{			
		$data = $user_obj->login( $_POST );
		if(isset($_SESSION['login']) && $_SESSION['login'])
		{
			header('Location: index.php');
		}
	}catch (Exception $e) { $error = $e->getMessage();}
}	
?>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="application/x-javascript">
		addEventListener("load", function ()
		{
			setTimeout(hideURLbar, 0);
		}, false);
		function hideURLbar(){window.scrollTo(0, 1);}
	</script>
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="vendor/Login Form/css/style.css" type="text/css" media="all">
	<link rel="stylesheet" href="vendor/Login Form/css/font-awesome.min.css">
	<link href="vendor/Login Form/css/css" rel="stylesheet">
	<?php require_once('templates/common_css.php');?>
	<link href="css/login.css" rel="stylesheet">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<style>
	.sub-main-w3{
		margin:165px auto;
	}
	.right-w3l{
		margin-top:10px;
		
	}
	.login-txt-center{
		color:white;
	}
	.footer{
		color:white;
	}
</style>
</head>
<body>
	<?php require_once('templates/header.php');?>	
	<div class="main-content-agile">
		<div class="sub-main-w3">
			<h2>Login Here</h2>
			<form id="login-form" method="post"  action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<?php require_once 'templates/message.php';?>
				<div class="text-center login-txt-center" style="padding-bottom:10px;"><?php echo $smsg; ?></div>
				<div class="pom-agile">
					<span class="fa fa-user" aria-hidden="true"></span>
					<input placeholder="email " name="email"  id="email" type="email" autofocus>
					<span class="help-block"></span>
				</div>
				<div class="pom-agile">
					<span class="fa fa-key" aria-hidden="true"></span>
					<input placeholder="Password" name="password" id="password" type="password" type="password" required="">
					<span class="help-block"></span>
				</div>				
				<div class="right-w3l">
					<button class="btn btn-block bt-login" type="submit">Sign in</button>
				</div>
				<h6 class="text-center login-txt-center">Alternatively, you can log in using:</h6>					
				<div class="row">
					<div class="col-lg-4"></div> 
					<div class="col-lg-2">
						<a class="btn btn-default facebook_rnd" href="login-account.php?type=facebook"> <i class="fa fa-facebook modal-icons-rnd"></i></a> 
					</div>
					<div class="col-lg-2">				
						<a class="btn btn-default google_rnd" href="login-account.php?type=google"> <i class="fa fa-google modal-icons-rnd"></i> </a>
					</div>
					<div class="col-lg-4"></div>
				</div>			  
				<div class="row footer">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<i class="fa fa-lock"></i>
						<a href="password_new.php" class="footer"> Forgot password? </a>

					</div>
					
					<div class="col-xs-6 col-sm-6 col-md-6 ">
						<i class="fa fa-check"></i>
						<a href="register.php" class="footer" > Sign Up </a>
					</div>
				</div>

				<div class="sub-w3l">
					<div class="sub-agile">
						<input type="checkbox" id="brand1" value="">
						
					</div>

					<div class="clear"></div>
				</div>

			</form>
		</div>
	</div>
	<?php require_once('templates/footer.php'); ?>
	<?php require_once('templates/common_js.php');?>
	<script src="js/jquery.validate.min.js"></script>
	<script src="js/login.js"></script>
	<script src="js/register-new.js"></script>
	<?php ob_end_flush(); ?>
</body>
</html>