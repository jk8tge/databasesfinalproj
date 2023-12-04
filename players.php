<?php
require("nav.php");
require("connect-db.php");
?>

<!DOCTYPE html>

<html>

<head>
    <title>players.php</title>
    <link rel="stylesheet" href="css/players.css">
</head>

<body>

<?php

function addPlayer($db, $pid, $fname, $lname, $country, $age, $team){
  $query = "INSERT INTO players (`player_ID`, `First_Name`, `Last_Name`, `country`, `age`) VALUES (\"" . $pid . "\", \"" . $fname . "\", \"" . $lname . "\", \"" . $country . "\", " . $age . "); 
  INSERT INTO affiliation (`player_ID`, `team_name`) VALUES (" . $pid . ", '" . $team . "');";
  //echo $query;
  $db->query($query);
}

function getAllPlayers($db, $searchby, $sortby, $orderby){
  if($searchby == -1 && $sortby == -1){ // default load
    return $db->query("SELECT * FROM players NATURAL JOIN affiliation");
  } else if ($searchby == -1){ // sort
    return $db->query("SELECT * FROM players NATURAL JOIN affiliation ORDER BY " . $sortby . " " . $orderby);
  } else { // search
    return $db->query("SELECT * FROM players NATURAL JOIN affiliation WHERE First_Name = '" . $searchby . "' OR Last_Name = '" . $searchby . "';");
  }
}

function removePlayer($db, $player_ID){
  $query = "DELETE FROM players WHERE player_ID='" . $player_ID . "';";
  echo $query;
  $db->query($query);
}

function updatePlayer($db, $player_ID, $fname, $lname, $country, $age){
  $query = "UPDATE players SET First_Name=:fname, Last_Name=:lname, country=:country, age=:age WHERE player_ID=:player_ID";
  $statement = $db->prepare($query);
  $statement->bindValue(':fname', $fname);
  $statement->bindValue(':lname', $lname);
  $statement->bindValue(':country', $country);
  $statement->bindValue(':age', $age);
  $statement->bindValue(':player_ID', $player_ID);
  $statement->execute();
  $statement->closeCursor();
}

function favPlayer($db, $username, $player_ID){
  $qry = "INSERT INTO favorites (username, player_ID) VALUES ('" . $username . "', " . $player_ID . ")";
  $db->query($qry);
}

$table = getAllPlayers($db, -1, -1, -1);
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if (!empty($_POST['updateBtn'])){
    //echo greet($_POST['name']);
    //addPlayer($db, $_POST['name'], $_POST['major'], $_POST['year']);
  }
  else if (!empty($_POST['confirmBtn'])){
    updatePlayer($db, $_POST['player_ID'], $_POST['fname'], $_POST['lname'], $_POST['country'], $_POST['age']);
  }
  else if (!empty($_POST['removeBtn'])){
    echo $_POST['pid_to_delete'];
    removePlayer($db, $_POST['pid_to_delete']);
  }
  else if (!empty($_POST['favBtn'])){
    echo $_POST['pid_add_to_fav'];
    favPlayer($db, $_SESSION['username'], $_POST['pid_add_to_fav']);
  }
  else if (!empty($_POST['addBtn'])){
    addPlayer($db, $_POST['player_ID'], $_POST['fname'], $_POST['lname'], $_POST['country'], $_POST['age'], $_POST['team']);
  }
  else if (!empty($_POST['serachBtn'])){
    $table = getAllPlayers($db, $_POST['name_search'], -1, -1);
  } 
  else if (!empty($_POST['sortBtn'])){
    $table = getAllPlayers($db, -1, $_POST['sort_by'], $_POST['order_by']);
  } 

}
?>

<div class="container">
  <h1>MLB Players</h1>
  <?php 
    // if(isset($_POST['name'])){
    //   echo greet($_POST['name']);
    //   addPlayer($db, $_POST['name'], $_POST['major'], $_POST['year']);
    //   } 
  ?>
  <form name="mainForm" action="players.php" method="post">   
    <div class="row mb-3 mx-3">
      Player ID:
      <input type="text" class="form-control" name="player_ID" required value="<?php if(isset($_POST['pid_to_update'])){echo $_POST['pid_to_update'];} ?>"/>        
    </div>
    <div class="row mb-3 mx-3">
      Player First Name:
      <input type="text" class="form-control" name="fname" required value="<?php if(isset($_POST['fname_to_update'])){echo $_POST['fname_to_update'];} ?>"/>        
    </div>
    <div class="row mb-3 mx-3">
      Player Last Name:
      <input type="text" class="form-control" name="lname" required value="<?php if(isset($_POST['lname_to_update'])){echo $_POST['lname_to_update'];} ?>"/>        
    </div>
    <div class="row mb-3 mx-3">
      Player country:
      <input type="text" class="form-control" name="country" required value="<?php if(isset($_POST['country_to_update'])){echo $_POST['country_to_update'];}?>"/>        
    </div>
    <div class="row mb-3 mx-3">
      Player Age:
      <input type="text" class="form-control" name="age" required value="<?php if(isset($_POST['age_to_update'])){echo $_POST['age_to_update'];} ?>"/>        
    </div>
    <div class="row mb-3 mx-3">
      Player Team:
      <input type="text" class="form-control" name="team" required value="<?php if(isset($_POST['team_to_update'])){echo $_POST['team_to_update'];} ?>"/>        
    </div>
    <div class="row mb-3 mx-3">
      <input type="submit" value="Add player" name="addBtn"
              class="btn btn-primary" 
              title="Insert a player into a players table"/>        
      <input type="submit" value="Confirm Update" name="confirmBtn"
              class="btn btn-primary" 
              title="Insert a player into a players table"/>        
    </div>
  </form>   
</div>

<div class="container">
  <form action="players.php" method="post">
    <div>
      <label for="name_search">Search by Name: </label>
      <input type="text" class="form-control" name="name_search"/>
      <input type="submit" value="Search" name="serachBtn"
              class="btn btn-primary"/>   
    </div>
    <div>
      <label for="sort_by">Sort by: </label>
      <select class="form-control" name="sort_by">
        <option value="player_ID">PlayerID</option>
        <option value="First_Name">First Name</option>
        <option value="Last_Name">Last Name</option>
        <option value="age">Age</option>
      </select>
      <select class="form-control" name="order_by">
        <option value="ASC">Ascending</option>
        <option value="DESC">Descending</option>
      </select>
      <input type="submit" value="Sort" name="sortBtn"
            class="btn btn-primary"/>   
    </div>
  </form>
</div>

<div class="row justify-content-center">  
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
    <th width="20%">Update
    <th width="20%">Remove
    <th width="20">Favorite
  </tr>
  </thead>
<?php foreach ($table as $running_variable): ?>
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
        <input type="submit" value=" " class="btn btn-secondary" />
        <input type="hidden" name="pid_to_delete" value="<?php echo $running_variable['player_ID'];?>"/>
        <input type="hidden" name="pid_to_update" value="<?php echo $running_variable['player_ID'];?>"/>
        <input type="hidden" name="fname_to_update" value="<?php echo $running_variable['First_Name'];?>"/>
        <input type="hidden" name="lname_to_update" value="<?php echo $running_variable['Last_Name'];?>"/>
        <input type="hidden" name="country_to_update" value="<?php echo $running_variable['country'];?>"/>
        <input type="hidden" name="age_to_update" value="<?php echo $running_variable['age'];?>"/>
        <input type="hidden" name="team_to_update" value="<?php echo $running_variable['team_name'];?>"/>
      </form>
     </td>
     <td>
      <form action="players.php" method="post">
        <input type="submit" value=" " name="removeBtn" class="btn btn-secondary" />
        <input type="hidden" name="pid_to_delete" value="<?php echo $running_variable['player_ID'];?>"/>
      </form>
     </td>  
     <td>
      <form action="players.php" method="post">
        <input type="submit" value=" " name="favBtn" class="btn btn-secondary" />
        <input type="hidden" name="pid_add_to_fav" value="<?php echo $running_variable['player_ID'];?>"/>
      </form>
     </td>            
  </tr>
<?php endforeach; ?>
</table>
</div>   

</body>

