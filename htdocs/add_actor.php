<?php
  include 'universal.php';
  
  $db = connect();
  $query_shows = "select Shows.Title, Shows.ShowID
    from Shows, RelShowUser
    where RelShowUser.UserID = :user and RelShowUser.ShowID = Shows.ShowID";
  $show_stmt = $db->prepare($query_shows);
  $show_stmt->bindParam(':user', $_SESSION['userid'] );
  $show_stmt->execute();
  $showArr = array();
  foreach($show_stmt->fetchAll(PDO::FETCH_ASSOC) as $result )
  {
    array_push($showArr, $result['ShowID'], $result['Title']);
  }
?>
<?php include 'header.php';?>
  <h1>Add an Actor</h1>
  <div id="center">
  <form action="insert_actor.php" method="post">
    <label for="first"> First:</label><br />
      <input type="text" name="first" id="first"><br />
    <label for="last">Last:</label><br />
      <input type="text" name="last" id="last"><br />
    <label for="show">Show:</label>
      <select name="show">
<?php
  $size = sizeof($showArr);
  for($i = 0; $i < $size-1; $i=$i+2 )
  {
    echo '<option value='.$showArr[$i].'>'.$showArr[$i+1].'</option>';
  }
?>
      </select>
     <!-- <input type="text" name="show" id="show"><br />-->
    <div class="buttonCenter">
      <input type="submit" value="Save">
    </div>

  </form>
  </div>
<?php nav_bar(); ?>
<?php include 'footer.php'; ?>
