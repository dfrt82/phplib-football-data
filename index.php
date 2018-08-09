<?php
  include 'FootballData.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>phplib football-data.org</title>
        <link href="./css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div class="container">
                <div class="page-header">
                    <h1>Showcasing some library functions...</h1>
                </div>
                <?php
                // Create instance of API class
                $api = new FootballData();
                echo "<p><hr><p>"; ?>
                <h3>Matches for the 2nd matchday of the Premiere League</h3>
                <table class="table table-striped">
                    <tr>
                    <th>HomeTeam</th>
                    <th></th>
                    <th>AwayTeam</th>
                    <th colspan="3">Result</th>
                    </tr>
                    <?php foreach ($api->findMatchesByCompetitionAndMatchday(2021, 2)->matches as $match) { ?>
                    <tr>
                        <td><?php echo $match->homeTeam->name; ?></td>
                        <td>-</td>
                        <td><?php echo $match->awayTeam->name; ?></td>
                        <td><?php echo $match->score->fullTime->homeTeam;  ?></td>
                        <td>:</td>
                        <td><?php echo $match->score->fullTime->awayTeam;  ?></td>
                    </tr>
                    <?php } ?>
                </table>
            <?php
                echo "<p><hr><p>";
                // fetch all available upcoming matches for the next 3 days
                $now = new DateTime();
                $end = new DateTime(); $end->add(new DateInterval('P3D'));
                $response = $api->findMatchesForDateRange($now->format('Y-m-d'), $end->format('Y-m-d'));
            ?>
            <h3>Upcoming matches within the next 3 days</h3>
                <table class="table table-striped">
                    <tr>
                        <th>HomeTeam</th>
                        <th></th>
                        <th>AwayTeam</th>
                        <th colspan="3">Result</th>
                    </tr>
                    <?php foreach ($response->matches as $match) { ?>
                    <tr>
                        <td><?php echo $match->homeTeam->name; ?></td>
                        <td>-</td>
                        <td><?php echo $match->awayTeam->name; ?></td>
                        <td><?php echo $match->score->fullTime->homeTeam; ?></td>
                        <td>:</td>
                        <td><?php echo $match->score->fullTime->awayTeam; ?></td>
                    </tr>
                    <?php } ?>
                </table>

            <?php
                echo "<p><hr><p>";
                $matches = $api->findHomeMatchesByTeam(62);
            ?>
                <h3>All home matches of Everton FC:</h3>
                <table class="table table-striped">
                    <tr>
                        <th>HomeTeam</th>
                        <th></th>
                        <th>AwayTeam</th>
                        <th colspan="3">Result</th>
                    </tr>
                    <?php foreach ($matches as $match) { ?>
                    <tr>                        
                        <td><?php echo $match->homeTeam->name; ?></td>
                        <td>-</td>
                        <td><?php echo $match->awayTeam->name; ?></td>
                        <td><?php echo $match->score->fullTime->homeTeam;  ?></td>
                        <td>:</td>
                        <td><?php echo $match->score->fullTime->awayTeam;  ?></td>
                    </tr>
                    <?php } ?>
                </table>

            <?php
                echo "<p><hr><p>";
                // show players of a specific team
                $team = $api->findTeamById(62);
            ?>
            <h3>Players of <?php echo $team->name; ?></h3>
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>Position</th>                    
                    <th>Date of birth</th>
                </tr>
                <?php foreach ($team->squad as $player) { ?>
                <tr>
                    <td><?php echo $player->name; ?></td>
                    <td><?php echo $player->position; ?></td>                    
                    <td><?php echo $player->dateOfBirth; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </body>
</html>
