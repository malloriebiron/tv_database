<?php
  include 'universal.php';
  $show_id = $_POST['showid'];
  $actor_id = $_POST['actorid'];

  $db = connect();

  try{
    $rel = "DELETE from RelShowActor
     where ShowID=:showid and ActorID=:actorid";
    $del = $db->prepare($rel);
    $del->bindParam(":showid", $show_id);
    $del->bindParam(":actorid", $actor_id);
    $del->execute();
  }
  catch( PDOException e )
  {

  }
?>
