<?php
  include 'universal.php';
  $first = trim($_POST['first']);
  $last = trim($_POST['last']);
  $title = trim($_POST['title']);
  $actor_id = null;
  $title_id = null;
  
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
  $checkTitle = "select ShowID  from Shows where Title =:show" ;
  $checkResult = $db->prepare($checkTitle);
  $checkResult->bindParam(':show', $title);
  $checkResult->execute();
  $result = $checkResult->fetchColumn();
  if( $result > 0 )
  {
    //show is in database 
    $title_id = $result; //get showID
  }
  
  $check = "select ActorID from Actors where First=:first and Last=:last" ;
  $checkActor = $db->prepare($check);
  $checkActor->bindParam(':first', $first );
  $checkActor->bindParam(':last', $last);
  $checkActor->execute();
  $result = $checkActor->fetchColumn();
  if( $result > 0 )
  {
    $actor_id = $result;//actor in table 
  }
  else
  {
    $add = "insert into Actors(First, Last)
      values(:first, :last)";
    $add_actor = $db->prepare($add);
    $add_actor->bindParam(':first', $first);
    $add_actor->bindParam(':last', $last);
    $add_actor->execute();
    if($add_actor->rowCount() > 0 )
    {
      $get_id = $db->query("select ActorID from Actors where First='".$first."'and Last='".$last."'");
      $idResult = $get_id->fetchColumn();
      if( $idResult > 0 )
      {
        $actor_id = $idResult;
      }
    }
  }

  if( $title_id != null && $actor_id != null )
  {
    $srel = "select * 
      from RelShowActor, Shows, Actors
      where Actors.ActorID = :actorid and Shows.ShowID = :showid and Actors.ActorID = RelShowActor.ActorID and
      RelShowActor.ShowID = Shows.ShowID";
    $checkRel = $db->prepare($srel);
    $checkRel->bindParam(':actorid', $actor_id);
    $checkRel->bindParam(':showid', $title_id);
    $checkRel->execute();
    if($checkRel->rowCount() > 0 )
    {
     // $error_msg .= "Actor has already been added to database";
    }
    else
    {
      $addR = "insert into RelShowActor(ShowID,ActorID)
        values(:showid, :actorid)";
      $addRel = $db->prepare($addR);
      $addRel->bindParam(':showid',$title_id);
      $addRel->bindParam(':actorid',$actor_id);
      $addRel->execute();
      if($addRel->rowCount() > 0 )
      {
       // $success_msg.= "Actor has been added";
      }
      else
      {
       // $error_msg.="Actor has not been added";
      }
    }
  }
  $db->connection = null;

?>
