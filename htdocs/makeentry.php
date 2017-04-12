<?php
  include 'universal.php';
  $db = connect();

  include'header.php';
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

  <h1>Add a Show</h1>
  <div id="center">
  <form action="insert_show.php" method="post">
   <label for="title">Title:</label><br />
    <input type="text" id="title" name="title" value="<?php echo $title; ?>"><br />
    <input type="hidden" name="showid" value="<?php echo $show_id; ?>"><br />
    <label for="genre">Genre:</label><br />
    <input type="text" id="genre" name="genre" value="<?php echo $genre; ?>"><br />
    <label for="seasons">Seasons:</label><br />
    <input type="number" id="seasons" name="seasons" value="<?php echo $seasons; ?>" min="1"><br />
    <label for"form">Actors:</label><br />
  <table id="actorform">
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
    <div class="buttonCenter">
      <input type="submit" value="Save" id="save">
    </div>
    </div>
  </form>
  </div>

<?php
  nav_bar();
  include 'footer.php';
?>


