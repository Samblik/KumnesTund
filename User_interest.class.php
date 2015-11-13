<?php
	class Interestmanger {
		
		private $connection;
		
		function __construct ($mysqli){
			
			$this->connection = $mysqli;
			
		}
		
		function addInterest($new_interest){
			
	
			
		$response = new StdClass();
		
		$stmt = $this->connection->prepare("SELECT name FROM Interests WHERE name = ?");
		$stmt->bind_param("s",$new_interest);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			//Saadan tagasi errori
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Sellinse huviala on juba olemas!";
			
			//panen errori responsile külge
			$response->error = $error;
			
			
			return $response;
			
		}
		
		//******************
		//***OLULINE********
		//******************
		
		//panen eelimse k2su kinni
		$stmt->close();
		
		$stmt = $this->connection->prepare("INSERT INTO Interests (name) VALUE ( ?)");
				
				//asendame ? muutujate v22rtustega
				
				//echo $mysqli->error;
				//echo $stmt->error;
				
				$stmt->bind_param("s",$new_interest);
				
				
				if($stmt->execute()){
					//edukalt salvestatud
					$success = new StdClass();
					$success->message = "Huviala Edukalt loodud";
					
					$response->success = $success;
				}else{
					//midagi l2ks katki
					$error = new StdClass();
					$error->id = 1;
					$error->message = "Midagi l2ks Katki!";
					
					$response->error = $error;
			
					
					
				}
				
				$stmt->close();
				
				//saadan tagasi vastuse, kas Sucess või Error
				return $response;
				
				
		
		
	
			
			
			
		}
		
		
		function addUserInterest($new_interest_id, $user_id){
			
	
			
		$response = new StdClass();
		
		$stmt = $this->connection->prepare("SELECT ID FROM User_interests WHERE user_ID = ? AND interests_ID = ?");
		$stmt->bind_param("ii", $user_id, $new_interest_id);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			//Saadan tagasi errori
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Sellinse huviala on juba olemas!";
			
			//panen errori responsile külge
			$response->error = $error;
			
			
			return $response;
			
		}
		
		//******************
		//***OLULINE********
		//******************
		
		//panen eelimse k2su kinni
		$stmt->close();
		
		$stmt = $this->connection->prepare("INSERT INTO User_interests (user_ID, interests_ID) VALUE (?, ?)");
				
				//asendame ? muutujate v22rtustega
				
				//echo $mysqli->error;
				//echo $stmt->error;
				
				$stmt->bind_param("ii",$user_id, $new_interest_id);
				
				
				if($stmt->execute()){
					//edukalt salvestatud
					$success = new StdClass();
					$success->message = "Huviala Edukalt loodud";
					
					$response->success = $success;
				}else{
					//midagi l2ks katki
					$error = new StdClass();
					$error->id = 1;
					$error->message = "Midagi l2ks Katki!";
					
					$response->error = $error;
			
					
					
				}
				
				$stmt->close();
				
				//saadan tagasi vastuse, kas Sucess või Error
				return $response;
				
				
		
		
	
			
			
			
		}
		
		
		
	

		function createDropdown(){
			
			$html = ' ';
			
			$html .= '<select name="dropdownselect">';
				
				//$html .= '<option value="1">Top</option>';
				$stmt = $this->connection->prepare("SELECT ID, name from Interests");
				$stmt->bind_result($ID, $name);
				$stmt->execute();
				while($stmt->fetch()){
					$html .= '<option value="'.$ID.'">'.$name.'</option>';
					
				
				}
					$stmt->close();
			
			$html .= '</select>';
			
			return $html;
			
		}
		
		function getUserInterests($user_id){
			$html = ' ';
			
			$stmt = $this->connection->prepare("SELECT Interests.name FROM User_interests INNER JOIN Interests ON User_interests.Interests_ID = Interests_ID WHERE User_interests.user_ID = ?");
			$stmt->bind_param("i", $this->user_id);
			$stmt->bind_result($name);
			$stmt->execute();
			
			while($stmt->fetch()){
				$html .= $name.' ';
				
			}
			$stmt->close();
			
			return $html;
			
			
		}
		
		
	}


?>



