	<?php
    include 'universal.php';
    $title = trim($_POST['title']);
    $genre = trim($_POST['genre']);
    $seasons = trim($_POST['seasons']);
    $show_id = null;
    $html_error_msg = "";
    $html_success_msg = "";
    $actors = array();
    foreach( $_POST['actor'] as $value)
    {
      array_push($actors, $value );
    }
    $html_error_msg = "";
    $html_success_msg="";
    $titleSet = false;
    $genreSet = false;

    $db = connect();
    //check length of title
    if(strlen($title) > 1 )
    {
      $titleSet = true;
    }
    //check seasons length
    if(strlen($genre) > 3 )
    {
      $genreSet = true;
    }

  if($titleSet && $genreSet)
  {
    $checkTitle = "select ShowID  from Shows where Title ='".$title."'" ;
    $checkResult = $db->query($checkTitle);
    $result = $checkResult->fetchColumn();
    if( $result > 0 )
    {
     //show is in database 
      $show_id = $result; //get showID
    }
    else{
     //show is not yet in database, must be added
      $add_query = "insert into Shows(Title, Genre, Seasons)
        values(:title, :genre, :seasons)";
      $add_Show = $db->prepare($add_query);
      $add_Show->bindParam(':title', $title );
      $add_Show->bindParam(':genre', $genre);
      $add_Show->bindParam(':seasons', $seasons);
      $add_Show->execute();
      if($add_Show->rowCount() > 0 )
      {
        $get_id = $db->query("select ShowID from Shows where Title='".$title."'");
        $idResult = $get_id->fetchColumn();
        if( $idResult > 0 )
        {
          $show_id = $idResult;
        }
      }
    }
    if( $show_id != null ) //check if user has show in database
    {
     $checkUser = "select * 
      from RelShowUser, Shows
      where Shows.ShowID = :showid and RelShowUser.UserID = :userid and Shows.ShowID = RelShowUser.ShowID";
     $u_stmt = $db->prepare($checkUser);
     $u_stmt->bindParam(':showid', $show_id );
     $u_stmt->bindParam( ':userid', $_SESSION['userid'] );
     $u_stmt->execute();

     $resultUser = $u_stmt->fetchColumn();
     if( $resultUser > 0 )
     {
      $html_error_msg .= "User has show in database";
     }
     else
     {
       // echo "<p>User does not have show in database, but show exists in database.</p>";
       // add User Show relationship
       $addRel = $db->prepare("insert into RelShowUser(ShowID, UserID) 
         values(:sid, :uid)");
       $addRel->bindParam(':sid', $show_id );
       $addRel->bindParam(':uid', $_SESSION['userid']);
       $addRel->execute();
       if( $addRel->rowCount() > 0 )
       {
        $html_success_msg .= "Show has been added";
       }
       else
       {
        $html_error_msg .= "Show has not been added to database";
       }
     }
    }
    foreach($actors as $id )
    {
      try{
        $add = "insert into RelShowActor(ShowID,ActorID)
          values(:showid, :actorid)";
        $addRel = $db->prepare($add);
        $addRel->bindParam(':showid',$show_id);
        $addRel->bindParam(':actorid',$id);
        $addRel->execute();
        if($addRel->rowCount() > 0 )
        {
          $html_success_msg.= "Actors have been updated.  ";
        }
        else
        {
          $html_error_msg.="Actor has not been added ";
        }
      }
      catch( PDOException $e )
      {

      }
    }
  }
  else
  {
    $html_error_msg .= "Invalid fields";
  }
    $db->connection = null;

	?>
  <?php include'header.php'; ?>
  <h1>My Show Entry Status</h1>
  <?php echo $html_success_msg; ?>
  <?php echo $html_error_msg; ?>
  <?php nav_bar(); ?>
  <?php include'footer.php'; ?>

