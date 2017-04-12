<?php
include 'universal.php';
include 'header.php';
?>

<body id="profile">
<div class="main">
<div class="box">
  <h2 >My Shows</h2>
  <form action="logout.php" method="post">
    <input type="submit" value="Logout" id="logout">
  </form>
</div>
  Usermame: <?php echo $_SESSION['valid_user']; ?></br >
  <p>My Shows: </p> 
  <!--Title Table Heading -->
  <table id="showTable" >
    <tr>
      <th>Show Title</th>
      <th>Genre</th>
      <th>Seasons</th>
    </tr>

  <?php

    $db = connect();
    $query_shows = "select *
      from RelShowUser, Shows
      where RelShowUser.UserID = :user and RelShowUser.ShowID = Shows.ShowID";
    $stmt = $db->prepare($query_shows);
    $stmt->bindParam(':user', $_SESSION['userid'] );
    $stmt->execute();
    //Title Table
    foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $result )
    { ?>
      <tr>
        <td><?= htmlspecialchars($result['Title']); ?></td>
        <td><?= htmlspecialchars($result['Genre']); ?></td>
        <td class="rightCol"><?= htmlspecialchars($result['Seasons']); ?></td>
        <td><form action="open_record.php" method="post">
            <input name="record" type="hidden" value=<?= htmlspecialchars($result['ShowID']); ?> >
            <input type="submit" value="Open Record">
        </form></td>
      </tr>
    <?php }  ?>
  </table>

  <!--Shows Talbe Headings -->
  <p>Actors:</p>
  <table id="actorTable">
    <tr>
      <th>Show Title</th>
      <th>First</th>
      <th>Last</th>
    </tr>
  <?php

   $query_actors = "select Actors.First, Actors.Last, Shows.Title
    from RelShowUser, RelShowActor, Shows, Actors
    where RelShowUser.UserID = :user and RelShowUser.ShowID = Shows.ShowID and RelShowActor.ShowID =  
    Shows.ShowID and RelShowActor.ActorID = Actors.ActorID
    order by Shows.ShowID asc";
  
   $a_stmt = $db->prepare($query_actors);
   $a_stmt->bindParam(':user', $_SESSION['userid'] );
   $a_stmt->execute();

   //Shows Table
   foreach($a_stmt->fetchAll(PDO::FETCH_ASSOC) as $a_result )
   { ?>
    <tr>
      <td><?= htmlspecialchars($a_result['Title']); ?></td>
      <td><?= htmlspecialchars($a_result['First']); ?></td>
      <td><?= htmlspecialchars($a_result['Last']); ?></td>
    </tr>
  <?php } ?>
  </table>
</div>
  <!-- Navigation Bar -->
<?php
   nav_bar();
   include 'footer.php';
?>
