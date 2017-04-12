<?php
  include 'universal.php';
  include 'header.php';
?>
  <h1>Delete an Actor</h1>
  <div id="center">
  <form action="delete_actor.php" method="post">
    <label for="first">First:</label><br />
      <input type="text" name="first" id="first"><br />
    <label for="last">Last:</label><br />
      <input type="text" name="last" id="last"><br />
    <label for="show">Show:</label><br />
      <input type="text" name="show" id="show"><br />
    <div class="buttonCenter">
      <input value="Delete" type="submit">
    </div>
  </form>
  </div>
<?php
  nav_bar();
  include 'footer.php';
?>
