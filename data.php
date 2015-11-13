<?php

		require_once("functions.php");
		require_once("User_interest.class.php");

	//Kontrollin kas kasutaja on sisse loginud
	if(!isset($_SESSION["id_from_db"])){
		header("Location: login_sample.php");
		
		exit();
		
		
		
	}
	//aadressireal on ?logout=?
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login_sample.php");
		
	}
	
	$Interestmanger = new Interestmanger($mysqli);
	

	if(isset($_GET["new_interest"])){
		
		$create_response = $Interestmanger->addInterest($_GET["new_interest"]);
		
	}
	
	if(isset($_GET["dropdownselect"])){
		
		$UserInterest_response = $Interestmanger->addUserInterest($_GET["dropdownselect"], $_SESSION["id_from_db"]);
	}



      
	

?>


<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>

<p>
	Tere, <?=$_SESSION["user_email"]; ?>
	<a href="?logout=1">Logi väljalja</a>
</p>

<h2>Lisa uus huviala</h2>

 <?php if(isset($create_response->error)): ?>
	<p style="color:red;"><?=$create_response->error->message; ?>
	</p>
  <?php elseif(isset($create_response->success)): ?>
  	<p style="color:green;"><?=$create_response->success->message; ?>
	</p>
  
  <?php endif; ?>

<form>
	<input name="new_interest">
	<input type="submit">
</form>


 <?php if(isset($UserInterest_response->error)): ?>
	<p style="color:red;"><?=$UserInterest_response->error->message; ?>
	</p>
  <?php elseif(isset($UserInterest_response->success)): ?>
  	<p style="color:green;"><?=$UserInterest_response->success->message; ?>
	</p>
  
  <?php endif; ?>

<h2>Minu huvialad</h2>
<form>
	<?php echo $Interestmanger->createDropdown(); ?>
	<input type="submit">
</form>

<p><?php  echo $Interestmanger->getUserInterests($_SESSION["id_from_db"]); ?></p>


<body>
<html>