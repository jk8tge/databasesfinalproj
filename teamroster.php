<?php
require("nav.php");
require("connect-db.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Team Roster</title>
    <link rel="stylesheet" href="css/teamstat.css">
</head>
<body>

<?php

$team_name = $_GET['team'];

function getAllTeamMember($db, $team_name){
    return $db->query("SELECT * FROM players NATURAL JOIN affiliation WHERE team_name = '" . $team_name . "'");
}

function getAllPostSeasonData($db, $team_name){
  return $db->query("SELECT * from plays_postseason natural join postseason_series where Team_Name1 = '" . $team_name . "' or Team_Name2 = '" . $team_name . "'");
}

// Array containing MLB team details for 2022f
$players = getAllTeamMember($db, $team_name);
$match = getAllPostSeasonData($db, $team_name)
?>

<div class="row justify-content-center">  
<h1><?php echo $team_name; ?> Team Roster</h1>
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
  </tr>
  </thead>
  <?php foreach ($players as $running_variable): ?>
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
  </tr>
  <?php endforeach; ?>
</table>
</div>

<div class="row justify-content-center">  
<h1><?php echo $team_name; ?> Post results</h1>
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="10%">Series Ttile       
    <th width="20%">Team1      
    <th width="20%">Team2
    <th width="15%">Result
  </tr>
  </thead>
  <?php foreach ($match as $running_variable): ?>
    <tr>
     <td><?php echo $running_variable['Series_Title']; ?></td>
     <td><?php echo $running_variable['Team_Name1']; ?></td>
     <td><?php echo $running_variable['Team_Name2']; ?></td>
     <td><?php echo $running_variable['Result']; ?></td>      
  </tr>
  <?php endforeach; ?>
</table>
</div>

</body>
</html>
