<?php

	// �henduse loomiseks kasuta
	require_once("functions.php");
	
	//Kontrollin kas kasutaja on sisse loginud
	if(isset($_SESSION["id_from_db"])){
		header("Location: data.php");
		
		
		
	}
	


  // muuutujad errorite jaoks
	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";
  // muutujad v��rtuste jaoks
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";
	if($_SERVER["REQUEST_METHOD"] == "POST") {
    // *********************
    // **** LOGI SISSE *****
    // *********************
		if(isset($_POST["login"])){
			if ( empty($_POST["email"]) ) {
				$email_error = "See v�li on kohustuslik";
			}else{
        // puhastame muutuja v�imalikest �leliigsetest s�mbolitest
				$email = cleanInput($_POST["email"]);
			}
			if ( empty($_POST["password"]) ) {
				$password_error = "See v�li on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}
      // Kui oleme siia j�udnud, v�ime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){
				
				
				$password_hash = hash("sha512", $password);
				//User klassi sees olev funtsioon
				$kek_response = $User->loginUser($email, $password_hash);
				
				
				if(isset($kek_response->success)){
					
					//var_dump($kek_response);
					//l2ks edukalt
					
					$_SESSION["id_from_db"] = $kek_response->success->user->id;
					$_SESSION["user_email"] = $kek_response->success->user->email;
					
					header("Location: data.php");
				
				//******************
				//***OLULINE********
				//******************
				//l6petame php laadimise
				exit();
				
				
				}


				
			}
		} // login if end
    // *********************
    // ** LOO KASUTAJA *****
    // *********************
    if(isset($_POST["create"])){
			if ( empty($_POST["create_email"]) ) {
				$create_email_error = "See v�li on kohustuslik";
			}else{
				$create_email = cleanInput($_POST["create_email"]);
			}
			if ( empty($_POST["create_password"]) ) {
				$create_password_error = "See v�li on kohustuslik";
			} else {
				if(strlen($_POST["create_password"]) < 8) {
					$create_password_error = "Peab olema v�hemalt 8 t�hem�rki pikk!";
				}else{
					$create_password = cleanInput($_POST["create_password"]);
				}
			}
			if(	$create_email_error == "" && $create_password_error == ""){
				
				
				$password_hash = hash("sha512", $create_password);

				
				$create_response = $User->createUser($create_email, $password_hash);
      }
    } // create if end
	}
  // funktsioon, mis eemaldab k�ikv�imaliku �leliigse tekstist
  function cleanInput($data) {
  	$data = trim($data); //tabulaator, t�hikud, Enter
  	$data = stripslashes($data); //Kaldkriipsud
  	$data = htmlspecialchars($data); // 
  	return $data;
  }
/**/
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>

  <h2>Log in</h2>
  
 <?php if(isset($kek_response->error)): ?>
	<p style="color:red;"><?=$kek_response->error->message; ?>
	</p>
  <?php elseif(isset($kek_response->success)): ?>
  	<p style="color:green;"><?=$kek_response->success->message; ?>
	</p>
  
  <?php endif; ?>
  
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
  	<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" name="login" value="Log in">
  </form>

  <h2>Create user</h2>
  <?php if(isset($create_response->error)): ?>
	<p style="color:red;"><?=$create_response->error->message; ?>
	</p>
  <?php elseif(isset($create_response->success)): ?>
  	<p style="color:green;"><?=$create_response->success->message; ?>
	</p>
  
  <?php endif; ?>
  
  
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
  	<input type="submit" name="create" value="Create user">
  </form>
<body>
<html>

