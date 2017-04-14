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

  try {
    $db = new PDO('mysql:host=localhost;dbname=MyShows_mdb1022', 'MyShows_mdb1022', 'MyShows_mdb1022', array (
      PDO::ATTR_PERSISTENT => true
    ));
  }
  catch(PDOException $e )
  {
    header("Location: connectionerror.html");
    exit;
  }


	$result = $db->prepare("select * from User
                         where Username=:username
                         and Password =:password");
  $result->bindParam(':username', $username );
  $result->bindParam(':password', sha1($password) );
  $result->execute();
  if (!$result)
  {
   	header("Location: nologin.html");
  	exit;
 	}
  if ($result->rowCount() > 0)
  {
    foreach( $result->fetchAll(PDO::FETCH_ASSOC) as $row )
    {
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
