<?php
require("nav.php");
require("connect-db.php");

$playerID = $_GET['playerID'];

function getPlayerName($db, $playerID) {
    $query = $db->query("SELECT First_Name, Last_Name FROM players WHERE player_ID = " . $playerID);
    return $query->fetch(PDO::FETCH_ASSOC);
}

function getHitterStats($db, $playerID) {
    return $db->query("SELECT * FROM hitter_stats WHERE player_ID = " . $playerID);
}

function getPitcherStats($db, $playerID) {
    return $db->query("SELECT * FROM pitcher_stats WHERE player_ID = " . $playerID);
}

function getPlayerAwards($db, $player_names){
    $fullName = $player_names['First_Name'] . " " . $player_names['Last_Name'];
    return $db->query("SELECT * FROM awards WHERE Recipient='" . $fullName . "'");
}

$hitterStats = getHitterStats($db, $playerID)->fetch(PDO::FETCH_ASSOC);
$pitcherStats = getPitcherStats($db, $playerID)->fetch(PDO::FETCH_ASSOC);
$player_names = getPlayerName($db, $playerID);
$player_awards = getPlayerAwards($db, $player_names)
?>

<!DOCTYPE html>
<html>
<head>
    <title>Player Statistics</title>
    <link rel="stylesheet" href="css/playerstat.css">
</head>
<body>
    <div class="stats-container">
        <h1>Stats for <?php echo htmlspecialchars($player_names['First_Name'] . " " . $player_names['Last_Name']); ?></h1>

        <?php if ($hitterStats): ?>
            <h2>Hitter Stats</h2>
            <table class="stats-table">
                <tr><th>ABs</th><td><?php echo htmlspecialchars($hitterStats['ABs']); ?></td></tr>
                <tr><th>Hits</th><td><?php echo htmlspecialchars($hitterStats['Hits']); ?></td></tr>
                <tr><th>Homeruns</th><td><?php echo htmlspecialchars($hitterStats['Homeruns']); ?></td></tr>
                <tr><th>Strikeouts</th><td><?php echo htmlspecialchars($hitterStats['Strikeouts']); ?></td></tr>
                <tr><th>Walks</th><td><?php echo htmlspecialchars($hitterStats['Walks']); ?></td></tr>
                <tr><th>BA</th><td><?php echo htmlspecialchars($hitterStats['BA']); ?></td></tr>
            </table>
        <?php endif; ?>

        <?php if ($pitcherStats): ?>
            <h2>Pitcher Stats</h2>
            <table class="stats-table">
                <tr><th>Inning Pitched</th><td><?php echo htmlspecialchars($pitcherStats['Innings_Pitched']); ?></td></tr>
                <tr><th>Strikeouts</th><td><?php echo htmlspecialchars($pitcherStats['Strikeouts']); ?></td></tr>
                <tr><th>Wins</th><td><?php echo htmlspecialchars($pitcherStats['Wins']); ?></td></tr>
                <tr><th>Losses</th><td><?php echo htmlspecialchars($pitcherStats['Losses']); ?></td></tr>
                <tr><th>ERA</th><td><?php echo htmlspecialchars($pitcherStats['ERA']); ?></td></tr>
            </table>
        <?php endif; ?>
    </div>

    <div class="stats-container">  
        <h1>Player Awards</h1>
        <table class="stats-table">
            <thead>
            <tr>
                <th width="10%">Award Name     
                <th width="20%">League      
                <th width="20%">Recipient
                <th width="15%">Team
            </tr>
            </thead>
            <?php foreach ($player_awards as $running_variable): ?>
            <tr>
                <td><?php echo $running_variable['Award_Name']; ?></td>
                <td><?php echo $running_variable['League']; ?></td>
                <td><?php echo $running_variable['Recipient']; ?></td>
                <td><?php echo $running_variable['Team_Name']; ?></td>      
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
