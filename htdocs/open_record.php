<?php
  include 'universal.php';
  include 'header.php';
  $show_id = $_POST['record'];
  $title="";
  $genre="";
  $seasons="";
  $db = connect();

  $query_show = "Select * from Shows
    where ShowID=:showid";
  $show_query = $db->prepare($query_show);
  $show_query->bindParam(':showid', $show_id);
  $show_query->execute();
  foreach($show_query->fetchAll(PDO::FETCH_ASSOC) as $result )
  {
    $title = $result['Title'];
    $genre= $result['Genre'];
    $seasons= $result['Seasons'];
  }
  $query_actors = "select Actors.ActorID, Actors.First, Actors.Last
    from Actors
    JOIN RelShowActor ON (Actors.ActorID = RelShowActor.ActorID)
    WHERE RelShowActor.ShowID = :showid";
  $actor_query = $db->prepare($query_actors);
  $actor_query->bindParam(':showid', $show_id);
  $actor_query->execute();
  $actorArr = array();
  foreach($actor_query->fetchAll(PDO::FETCH_ASSOC) as $a_result )
  {
    array_push($actorArr, $a_result['First'], $a_result['Last'], $a_result['ActorID']);
  }

  $query_all = "select * from Actors";
  $all_stmt = $db->query($query_all);
  $allArr = array();
  foreach($all_stmt->fetchAll(PDO::FETCH_ASSOC) as $allresult)
  {
    array_push($allArr, $allresult['ActorID'], $allresult['First']." ".$allresult['Last']);
  } 
?>
  <script src="jquery-3.1.1.min.js"></script>
  <script src="open_record_script.js"></script>
  <h1>Show Form</h1>
  <div id="center">
  <form method="post" action="edit_record.php"> 
    <label for="title">Title:</label><br />
    <input type="text" id="title" name="title" value="<?= htmlspecialchars($title); ?>"><br />
    <input type="hidden" name="showid" value="<?= htmlspecialchars($show_id); ?>"><br />
    <label for="genre">Genre:</label><br />
    <input type="text" id="genre" name="genre" value="<?= htmlspecialchars($genre); ?>"><br />
    <label for="seasons">Seasons:</label><br />
    <input type="number" id="seasons" name="seasons" value="<?= htmlspecialchars($seasons); ?>" min="1"><br />
    <label for"form">Actors:</label><br />
  <table id="actorform">
<?php
   $size = sizeof($actorArr);
  for($i = 0; $i < $size-2; $i=$i+3 )
  {
    echo '<tr><td>'.$actorArr[$i].'</td>
      <td>'.$actorArr[$i+1].'</td>
      <td><input name="actor[]" type="hidden" class="delete" value="'.$actorArr[$i+2].'">
      <button type="button" class="remove">Remove</button></td>
      </tr>';
  }
?>
  </table>  
    <select name="actors" id="actors">
<?php
  $sizeAll = sizeof($allArr);
  for($n = 0; $n < $sizeAll-1; $n=$n+2 )
  {
    echo '<option value='.$allArr[$n].'>'.$allArr[$n+1].'</option>';
  }
?>
    </select>
    <button id="addactor">Add</button><br />
    <button type="button" id="addnewact">Add New Actor</button><br />
      <input type="submit" value="Save" id="save">
      <input type="submit" name="delete" value="Delete">
      <input type="submit" name="destroy" value="Delete from Entire Database">
    </div>
  </form>
  </div>

<?php
  nav_bar();
  include 'footer.php';
?>
