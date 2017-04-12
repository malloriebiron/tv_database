<?php
  include 'universal.php';
  $first = trim($_POST['first']);
  $last = trim($_POST['last']);
  $show = trim($_POST['show']);
  $actor_id = null;
  $html_error_msg = "";
  $html_success_msg ="";

  $db = connect();
   //check for show in database
  /**$checkTitle = "select ShowID  from Shows where Title =:show" ;
  $checkResult = $db->prepare($checkTitle);
  $checkResult->bindParam(':show', $show );
  $checkResult->execute();
  $result = $checkResult->fetchColumn();
   if( $result > 0 )
   {
     //show is in database 
      $show_id = $result; //get showID
   }
   else
   {
      $html_error_msg.= "Show is not yet in database, please add it";
   }
   **/
   //check for actor
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
  //check show relation
   if( $show != null && $actor_id != null )
   {
     $srel = "select * 
       from RelShowActor, Shows, Actors
       where Actors.ActorID = :actorid and Shows.ShowID = :showid and Actors.ActorID = RelShowActor.ActorID and
       RelShowActor.ShowID = Shows.ShowID";

     $checkRel = $db->prepare($srel);
     $checkRel->bindParam(':actorid', $actor_id);
     $checkRel->bindParam(':showid', $show);
     $checkRel->execute();
     if($checkRel->rowCount() > 0 )
     {
       $html_error_msg .= "Actor has already been added to database";
     }
     else
      {
       $addR = "insert into RelShowActor(ShowID,ActorID)
         values(:showid, :actorid)";
       $addRel = $db->prepare($addR);
       $addRel->bindParam(':showid',$show);
       $addRel->bindParam(':actorid',$actor_id);
       $addRel->execute();
       if($addRel->rowCount() > 0 )
       {
        $html_success_msg.= "Actor has been added";
       }
       else
       {
        $html_error_msg.="Actor has not been added";
       }  
     }    
   }
   $db->connection = null;

?>
<?php include 'header.php'; ?>
  <h1>Add an Actor</h1>
  <?php echo $html_error_msg; ?>
  <?php echo $html_success_msg; ?>

<?php nav_bar(); ?>
<?php include 'footer.php'; ?>
