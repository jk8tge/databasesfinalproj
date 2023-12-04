<?php
require("nav.php");
require("connect-db.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Favorites</title>
    <link rel="stylesheet" href="css/teamstat.css">
</head>
<body>

<?php

function getAllFavorites($db, $username){
    return $db->query("SELECT * FROM players NATURAL JOIN affiliation WHERE player_ID IN (SELECT player_ID FROM favorites WHERE username = '" . $username . "')");
}

function removePlayer($db, $player_ID, $username){
    $query = "DELETE FROM favorites WHERE player_ID='" . $player_ID . "' AND username='" . $username . "';";
    echo $query;
    $db->query($query);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (!empty($_POST['removeBtn'])){
      echo $_POST['pid_to_delete'];
      removePlayer($db, $_POST['pid_to_delete'], $_SESSION['username']);
    }
}

$user_favorites = getAllFavorites($db, $_SESSION['username']);
?>

<div class="row justify-content-center">  
<h1>Your Favorited Players</h1>
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="10%">Player ID        
    <th width="20%">First Name        
    <th width="20%">Last Name
    <th width="15%">Country
    <th width="5%">Age
    <th width="30%">Team Name
    <th width="10%">Detailed Stats
    <th width="20%">Remove from Favorites
  </tr>
  </thead>
  <?php foreach ($user_favorites as $running_variable): ?>
    <tr>
     <td><?php echo $running_variable['player_ID']; ?></td>
     <td><?php echo $running_variable['First_Name']; ?></td>
     <td><?php echo $running_variable['Last_Name']; ?></td>
     <td><?php echo $running_variable['country']; ?></td>        
     <td><?php echo $running_variable['age']; ?></td>
     <td><?php echo $running_variable['team_name']; ?></td>
     <td>
      <a href=<?php echo "playerstat.php?playerID=" . $running_variable['player_ID'];?>>GO</a>
     </td>
     <td>
      <form action="players.php" method="post">
        <input type="submit" value=" " name="removeBtn" class="btn btn-secondary" />
        <input type="hidden" name="pid_to_delete" value="<?php echo $running_variable['player_ID'];?>"/>
      </form>
     </td>          
  </tr>
  <?php endforeach; ?>
</table>
</div>

</body>
</html>
