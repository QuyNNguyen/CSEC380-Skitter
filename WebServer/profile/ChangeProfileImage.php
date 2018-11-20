<?php
// Authenticate user 



// make database connection 
include_once("connect.php");


// Check CSRF token
if(!isset($_POST['token'])) {
	die("Change pic from main profile!");
} else {
	if (hash_equals($_SESSION['token'], $_POST['token']) === false) {
		die("Invalid session");
	}
}	




// Update database with new pic 

if(isset($_POST['new_profile_pic'])){
	if($stmt = $mysqli->prepare("UPDATE users SET profile_pic=? WHERE rit_user=?")){
		if($stmt->bind_param("b", $new_profile_pic, $_POST['rit_user'])){
			if(!$stmt->execute()){
				die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
			}
		}else{
			die("Error - Issue binding prepared statement: " . mysqli_error($mysqli));
		}
		if($stmt->close()){
			echo "Name changed successfully";
		}else{
			die("Error - Failed to close prepared statement" . mysqli_error($mysqli));
		}
	}else{
		die("Error - Issue preparing statement: " . mysqli_error($mysqli));
	}
}

?>