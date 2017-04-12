<?php
session_start();
$userid = $_SESSION['userid'];

if(!isset($_SESSION['userid']) )
{
    header("Location: index.html");
    exit;
}

function nav_bar(){
  echo '<div id="nav">
     <ul>
       <li><a href="profile.php">Profile</a></li>
       <li><a href="makeentry.php">Add a Show</a></li>
       <li><a href="add_actor.php">Add an Actor</a></li> 
       <li><a href="remove_show.php">Delete a Show</a></li>
       <li><a href="remove_actor.php">Delete an Actor</a></li>
     </ul>
   </div>';
}

function connect(){
  try {
    $connection = new PDO('mysql:host=localhost;dbname=MyShows_mdb1022', 'MyShows_mdb1022', 'MyShows_mdb1022', array (
      PDO::ATTR_PERSISTENT => true
    ));
  }
  catch(PDOException $e )
  {
    header("Location: connectionerror.html");
    exit;
  }
  return $connection;
}
?>
