
<?php
// Authenticate user 



// make database connection 
include_once("connect.php");


// Check CSRF token
if(!isset($_POST['token'])) {
	die("Change name from main profile!");
} else {
	if (hash_equals($_SESSION['token'], $_POST['token']) === false) {
		die("Invalid session");
	}
}	


// Sanitize input
if( isset( $_POST[ 'new_name' ]  ) ) {

	$new_name = trim($_POST[ 'new_name' ]);

	// Set blacklist
	$substitutions = array(
		'&'  => '',
		';'  => '',
		'| ' => '',
		'-'  => '',
		'$'  => '',
		'('  => '',
		')'  => '',
		'`'  => '',
		'||' => '',
		'<' => '',
		'>' => '',
		'/' => '',
		'\\' => '',

	);

	// Remove any of the charactars in the array (blacklist).
	$new_name = str_replace( array_keys( $substitutions ), $substitutions, $new_name );
}



// Update database with new name 
if(isset($_POST['new_profile_pic'])){
	if($stmt = $mysqli->prepare("UPDATE users SET display_name=? WHERE rit_user=?")){
		if($stmt->bind_param("si", $new_name, $_POST['rit_user'])){
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