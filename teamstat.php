<?php
require("nav.php");
require("connect-db.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Team Statistics</title>
    <link rel="stylesheet" href="css/teamstat.css">
</head>
<body>

<?php

function getAllTeams($db){
  return $db->query("SELECT * FROM teams");
}
// Array containing MLB team details for 2022f
$mlb_teams = getAllTeams($db);
?>

<div class="row justify-content-center">  
<h1>MLB Teams</h1>
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="20%">Team Name</th>
    <th width="15%">Home Ground</th>
    <th width="10%">Manager</th>
    <th width="5%">Wins</th>
    <th width="5%">Losses</th>
    <th width="5%">Team ERA</th>
    <th width="5%">Team BA</th>
    <th width="5%">Team Roster</th>
  </tr>
  </thead>
  <?php foreach ($mlb_teams as $team): ?>
    <tr>
      <td><?php echo $team['Team_Name']; ?></td>
      <td><?php echo $team['HomeGround']; ?></td>
      <td><?php echo $team['Manager']; ?></td>
      <td><?php echo $team['Wins']; ?></td>
      <td><?php echo $team['Losses']; ?></td>
      <td><?php echo $team['Team_ERA']; ?></td>
      <td><?php echo $team['Team_BA']; ?></td>
      <td>
        <a href=<?php echo "teamroster.php?team=" . urlencode($team['Team_Name']);?>>GO</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
</div>

</body>
</html>
