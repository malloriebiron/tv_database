<?php
  include 'universal.php';
  include 'header.php';
  $show_id = $_POST['showid'];
  $title = trim( $_POST['title'] );
  $genre = trim( $_POST['genre'] );
  $seasons = trim( $_POST['seasons'] );
  $actors = array();
  foreach( $_POST['actor'] as $value)
  {
    array_push($actors, $value );
  }
  $html_error_msg = "";
  $html_success_msg="";
  $db = connect();

  if( isset( $_POST['delete']) )
  {
    $delete = "delete from RelShowUser
      where ShowID=:showid and UserID=:userid";
    $delShow = $db->prepare($delete);
    $delShow->bindParam(':showid', $show_id );
    $delShow->bindParam(':userid', $userid );
    $delShow->execute();
    if($delShow->rowCount() > 0 )
    {
      $html_success_msg = "Show has been deleted";
    }
  }
  else if( isset( $_POST['destroy']) )
  {
    $dq = "delete from Shows
      where ShowID=:showid";
    $destroy = $db->prepare($dq);
    $destroy->bindParam(':showid', $show_id );
    $destroy->execute();
    if($destroy->rowCount() > 0 )
    {
      $html_success_msg = "Show has been removed from database.";
    }
    else
    {
      $html_error_msg = "Show was not removed.";
    }
  }
  else
  {
    if( $show_id != null && strlen($title) > 1
      && strlen($genre) > 1 )
    {
      $update = "UPDATE Shows
        SET Title=:title, Genre=:genre, Seasons=:seasons
        WHERE ShowID=:showid";
      $u_stmt = $db->prepare($update);
      $u_stmt->bindParam(':title', $title );
      $u_stmt->bindParam(':genre', $genre );
      $u_stmt->bindParam(':seasons', $seasons );
      $u_stmt->bindParam(':showid', $show_id);
      $u_stmt->execute();
      if($u_stmt->rowCount() > 0 )
      {
        $html_success_msg .= "Show has been edited ";
      } 
      else
      {
        $html_error_msg .= "Show has not been edited, no changes were made.  ";
      }
    }
    else 
    {
      $html_error_msg .= "Invalid fields ";
    }

    $del = "delete from RelShowActor
      where ShowID=:showid";
    $delAct = $db->prepare($del);
    $delAct->bindParam(':showid', $show_id);
    $delAct->execute();

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
?>
    <h1>Entry Edit</h1>
<?php
  echo $html_success_msg;
  echo $html_error_msg;
  nav_bar();
  include 'footer.php';
?>
