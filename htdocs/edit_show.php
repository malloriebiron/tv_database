<?php 
  session_start();
  $userid = $_SESSION['userid'];

  $title = trim($_POST['title']);
  $genre = trim($_POST['genre']);
  $seasons = trim($_POST['seasons']);
  $show_id = null;
  $html_error_msg = "";
  $html_success_msg = "";
  $titleExist = false;
  $genreExist = false;
  $seasonExist = false;
  $showRel = false;
  try {
    $db = new PDO('mysql:host=localhost;dbname=MyShows_mdb1022', 'MyShows_mdb1022', 'MyShows_mdb1022');
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  }
  catch(PDOException $e )
  {
    header("Location: connectionerror.html");
    exit;
  }
  //check if title is not Null
  if(strlen($title) > 0 )
  {
    $titleExist = true;
  }
  else
  {
    $html_error_msg .= "No title was entered. Cannot make edit";
  }

  //check if title is in database
  if($titleExist)
  {
    $checkTitle = "select ShowID  from Shows where Title =:title" ;
    $checkResult = $db->prepare($checkTitle);
    $checkResult->bindParam(':title', $title);
    $checkResult->execute();
    $result = $checkResult->fetchColumn();
    if( $result > 0 )
    {
      //show is in database 
      $show_id = $result; //get showID
    }
    else
    {
      $html_error_msg.= "Show is not yet in database, cannot be edited"; 
    }
    //check if user has show in their database                        
    if( $show_id != null && $userid != null )
    {
      $rel = "select * 
        from RelShowUser
        where ShowID = :showid and UserID = :userid";
      $checkRel = $db->prepare($rel);
      $checkRel->bindParam(':showid', $show_id);
      $checkRel->bindParam(':userid', $userid);
      $checkRel->execute();
      if($checkRel->rowCount() > 0)
      {
        $showRel = true;
      }
      else
      {
        $html_error_msg .= "Show is not yet in database, cannot be edited";
      }
    }

    if($showRel)
    {
      //check what to query
      if(strlen($genre) > 3 ) //check genre
      {
        $genreExist = true;
      }

      if(strlen($seasons) > 0 )//check seasons
      {
        $seasonExist = true;
      }
    }

    if($showRel && $genreExist && !$seasonExist)
    {
      //change genre
      $gen = "update Shows
        set Genre=:genre
        where ShowID=:showid";
      $chgen = $db->prepare($gen);
      $chgen->bindParam(':genre', $genre);
      $chgen->bindParam(':showid', $show_id);
      $chgen->execute();
      if($chgen->rowCount() > 0 )
      {
        $html_success_msg .= "Genre was changed";
      }
      else
      {
        $html_error_msg .= "Genre was unable to be changed";
      }
    }
    else if($showRel && $seasonExist && !$genreExist)
    {
      $seas = "update Shows
        set Seasons=:seasons
        where ShowID=:showid";
      $chgseas = $db->prepare($seas);
      $chgseas->bindParam(':seasons', $seasons);
      $chgseas->bindParam(':showid', $show_id);
      $chgseas->execute();
      if($chgseas->rowCount() > 0 )
      {
        $html_success_msg .= "Seasons was changed";
      }
      else
      {
        $html_error_msg .= "Seasons was unable to be changed";
      }
    }
    else if($showRel && $seasonExist && $genreExist)
    {
      $both = "update Shows
        set Seasons=:seasons, Genre=:genre
        where ShowID=:showid";
      $chgboth = $db->prepare($both);
      $chgboth->bindParam(':seasons', $seasons);
      $chgboth->bindParam(':genre', $genre);
      $chgboth->bindParam(':showid', $show_id);
      $chgboth->execute();
      if($chgboth->rowCount() > 0 )
      {
        $html_success_msg .= "Seasons and genre were changed";
      }
      else
      {
        $html_error_msg .= "Seasons and genre were unable to be changed";
      }
    }
    else
    {
      $html_error_msg .= "Invalid Fields";
    }
  }
  $db->connection = null;

?>
<?php
  include 'header.php';
?>
  <h1>Edit Show</h1>
  <?php echo $html_error_msg; ?>
  <?php echo $html_success_msg; ?>
<?php
  nav_bar();
  include 'footer.php';
?>
