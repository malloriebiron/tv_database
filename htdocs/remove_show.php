<?php
  include 'universal.php';
  include 'header.php';
?>
  <h1>Delete a Show</h1>

  <div id="center">
  <form action="delete_show.php" method="post">
    <label for="title">Title:</label><br />
    <input type="text" name="title" id="title"><br />
    <div class="buttonCenter">
      <input type="submit" value="Delete">
    </div>
  </form>
  </div>


<?php
  nav_bar();
  include 'footer.php';
?>
