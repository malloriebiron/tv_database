<?php
  include 'universal.php';
  $first = $_POST['first'];
  $last = $_POST['last'];
  $db = connect();

  $add = "insert into Actors(First, Last)
    values(:first, :last)";
  $addA = $db->prepare($add);
  $addA->bindParam(':first', $first);
  $addA->bindParam(':last', $last);
  $addA->execute();
  if($addA->rowCount() > 0 )
  { 
    $get = "select ActorID
     from Actors 
      where First=:first and Last=:last";
    $getID = $db->prepare($get);
    $getID->bindParam(':first', $first);
    $getID->bindParam(':last', $last);
    $getID->execute();
    $result = $getID->fetchColumn();
    $actorid = $result;
    echo $actorid;
  }   
?>
