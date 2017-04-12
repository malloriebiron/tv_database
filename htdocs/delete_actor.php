<?php
  include 'universal.php';
  $first = trim($_POST['first']);
  $last = trim($_POST['last']);
  $show = trim($_POST['show']);
  $html_error_msg = "";
  $html_success_msg = "";
  $actor_id = null;
  $show_id = null;
  $relation = false;
  
  try {
    $db = new PDO('mysql:host=localhost;dbname=MyShows_mdb1022', 'MyShows_mdb1022', 'MyShows_mdb1022');
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  }
  catch(PDOException $e )
  {
    header("Location: connectionerror.html");
    exit;
  }
  //check for actor
  $act = "select ActorID
    from Actors
    where First=:first and Last=:last";
  $checkAct = $db->prepare($act);
  $checkAct->bindParam(':first', $first);
  $checkAct->bindParam(':last', $last);
  $checkAct->execute();
  $actResult = $checkAct->fetchColumn();
  if($actResult > 0 )
  {
    $actor_id = $actResult;
  }
  else
  {
    $html_error_msg .= "Actor is not in database";
  }
  //check for show
  if($actor_id != null )
  {
    $showCheck = "select ShowID
      from Shows
      where Title=:show";
    $checkShow = $db->prepare($showCheck);
    $checkShow->bindParam(':show', $show);
    $checkShow->execute();
    $showResult = $checkShow->fetchColumn();
    if($showResult > 0 )
    {
      $show_id = $showResult;
    }
    else
    {
      $html_error_msg .= "Show is not in database";
    }
  }
  //check actor to show Relation
  if($actor_id != null && $show_id != null)
  {
    $rel = "select *
      from RelShowActor
      where ActorID=:actorid and ShowID=:showid";
    $checkRel = $db->prepare($rel);
    $checkRel->bindParam(':actorid', $actor_id);
    $checkRel->bindParam(':showid', $show_id);
    $checkRel->execute();
    if($checkRel->rowCount() > 0 )
    {
      $relation = true;
    }
    else
    {
      $html_error_msg .= "Actor is not in this Show";
    }
  }
  //delete show
  if($relation)
  {
    $del = "delete 
      from RelShowActor
      where ActorID=:actorid and ShowID=:showid";
    $delActor = $db->prepare($del);
    $delActor->bindParam(':actorid', $actor_id);
    $delActor->bindParam(':showid', $show_id);
    $delActor->execute();
    if($delActor->rowCount() > 0 )
    {
      $html_success_msg .= "Actor has been successfully deleted";
    }
    else
    {
      $html_error_msg .= "Actor was unable to be deleted";
    }
  }

?>
<?php
  include 'header.php';
?>
  <h1>Delete an Actor</h1>
  <?php echo $html_error_msg; ?>
  <?php echo $html_success_msg; ?>
<?php
  nav_bar();
  include 'footer.php';
?>
