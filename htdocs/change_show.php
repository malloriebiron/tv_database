<?php
  include 'universal.php';
  include 'header.php';
?>
  <h1>Edit Show</h1>
  <div id="center">
    <p id="biggerFont">Please enter the name of the show you would like to edit. Fill in the fields you wish to change.</p>

    <form action="edit_show.php" method="post">
      <label for="title">Title:</label><br />
      <input type="text" name="title" id="title"><br />
      <label for="genre">Genre:</label><br />
      <input type="text" name="genre" id="genre"><br />
      <label for="seasons">Seasons:</label><br />
      <input type="number" min="1" name="seasons" id="seasons">
      <div class="buttonCenter">
        <input type="submit" value="Submit">
      </div>

    </form>
  </div>
<?php
  nav_bar();
  include 'footer.php';
?>
