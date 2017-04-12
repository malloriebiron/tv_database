<?php
  include 'universal.php';
  
  $title = trim($_POST['title']);
  $show_id = null;
  $html_error_msg = "";
  $html_success_msg = "";
  $showRel = false;
  try {
   $db = new PDO('mysql:host=localhost;dbname=MyShows_mdb1022', 'MyShows_mdb1022', 'MyShows_mdb1022');
   $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  }
  catch(PDOException $e )
  {
   header("Location: connectionerror.html");
   exit;
  }

  //check for show in database
  $checkTitle = "select ShowID  from Shows where Title =:title" ;
  $checkResult = $db->prepare($checkTitle);
  $checkResult->bindParam(':title', $title);
  $checkResult->execute();
  $result = $checkResult->fetchColumn();
  if( $result > 0 )
  {
     //show is in database 
     $show_id = $result; //get showID
  }
  else
  {
     $html_error_msg.= "Show is not yet in database, cannot be deleted";
  }

  //check for User - Show Relationship
  if( $show_id != null && $userid != null )
  { 

    $rel = "select * 
      from RelShowUser
      where ShowID = :showid and UserID = :userid";
    $checkRel = $db->prepare($rel);
    $checkRel->bindParam(':showid', $show_id);
    $checkRel->bindParam(':userid', $userid);
    $checkRel->execute();
    if($checkRel->rowCount() > 0)
    {
     $showRel = true;
    }

    //delete show
    if($showRel)
    {
      $del = "delete
        from RelShowUser
        where ShowID = :showid and UserID = :userid";
      $delShow = $db->prepare($del);
      $delShow->bindParam(':showid', $show_id);
      $delShow->bindParam(':userid', $userid);
      $delShow->execute();
      if($delShow->rowCount() > 0 )
      {
        $html_success_msg .= "Show has been deleted";
      }
      else
      {
        $html_error_msg .= "Show was unable to be deleted";
      }
    }

  }
  $db->connection = null;

  
  
?>
<?php
  include 'header.php';
?>
  <h1>Delete a Show</h1>
  <?php echo $html_error_msg; ?>
  <?php echo $html_success_msg; ?>
<?php
  nav_bar();
  include 'footer.php';
?>
