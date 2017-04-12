<html>
<head>
	<title>Make a new Account</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
	<h1>New Account</h1>
	<?php
	$newuser = trim( $_POST['username']);
	$pass1 = trim( $_POST['password']);
	$pass2 = trim( $_POST['confirmpass']);
  $email = trim( $_POST['email']);
  $len = false;
		
	if( $pass1 != $pass2 ){
	  header('Location: pass_notmatch.html');
    exit;
	}
	
	$db = new mysqli( 'localhost', 'MyShows_mdb1022', 'MyShows_mdb1022', 'MyShows_mdb1022');
  if(mysqli_connect_errno()){       
    header("Location: connetionerror.html");
    exit;
  }

  if(strlen($newuser) > 3 && strlen($pass1) > 2 
    && strlen($email) > 4 )
  {
    $len = true;
  }
  else
  {
    echo "Fields were not long enough";
    echo '<p><a href="createaccount.html">Click here to try again</a></p>';
  }
  if( $len)
  {
	  $checkUser = $db->query("select * from User
                         where Username='".$newuser."'");
  	if ($checkUser->num_rows>0) {
      header('Location: username_exists.html');
     exit;
    }   
	
    $checkEmail = $db->query("select * from User where Email='".$email."'" );

    if($checkEmail->num_rows>0) {
    	header ('Location: email_exists.html');
    	exit;
	  } 

  	$query = "INSERT INTO User (Username, Password, Email) 
    	VALUES (?,?,?)";
  	$stmt = $db->prepare($query);
    $stmt->bind_param('sss', $newuser, sha1($pass1), $email );
  	$stmt->execute();

  	if ($stmt->affected_rows > 0 ){
    	echo "<p>User registered</p>";
      echo '<a href="index.html">Click here to login</a>';
	  } else {
    	echo "<p>An error has occurred.<br/>
	  	You were not registered.</p>";
    }
  }
	$db->close();
	?>
</body>
</html>
