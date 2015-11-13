<?php

		require_once("functions.php");

	//Kontrollin kas kasutaja on sisse loginud
	if(!isset($_SESSION["id_from_db"])){
		header("Location: login_sample.php");
		
		
		
	}
	//aadressireal on ?logout=?
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login_sample.php");
		
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

<h2>Pilt</h2>


<?php if(file_exists($target_file)): ?>

	<div style="width:250px; height:250px; background-image:url(<?=$target_file; ?>); background-position: center center; background-size: cover;"></div>
	<a href="?delete_image">Kustuta</a>

<?php else: ?>
<form action="data.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>
<?php endif; ?>


<body>
<html>