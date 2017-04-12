<html>
<head>
	<title>PHP Login</title>
</head>
<body>

	<?php
	
  session_start();

  
	
	$username = trim( $_POST['username']);
	$password = trim( $_POST['password']);
	echo $username. " is your username <br />"; 
	echo $password. " is your password" ;
	
	if(!isset($username) || !isset($password) )
  {
    echo "<p>You have not entered the proper credentials please try again.</p>";
    exit;       
  }

	
	$db = new mysqli( 'localhost', 'MyShows_mdb1022', 'MyShows_mdb1022', 'MyShows_mdb1022');

	if(mysqli_connect_errno()){
  	header("Location: connetionerror.html");
	  exit;
	}

	$result = $db->query("select * from User
                         where Username='".$username."'
                         and Password = sha1('".$password."')");
 	if (!$result) {
   	header("Location: nologin.html");
  	exit;
 	}

	if ($result->num_rows>0) {
    while($row = $result->fetch_assoc()){
     $userid = $row["UserID"];
    }

    $_SESSION['valid_user'] = $username;
    $_SESSION['userid'] = $userid;
    echo "<p>You are logged in.</p>"; 
    // echo '<p>Your valid password is '.$_SESSION['valid_user']. '</p>';
    // echo $userid. " is your userid";
    header("Location: profile.php");
	  exit;
 	}	
	else	{
  	header("Location: nologin.html");
  	exit;
	}
  $db->close();	
?>
</body>
</html>
