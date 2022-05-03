<?php
  include 'FootballData.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./css/bulma.min.css" type="text/css" rel="stylesheet" />
        <title>phplib football-data.org</title>
    </head>
    <body>
        <?php // Create instance of API class  
              $api = new FootballData(); 
        ?>
        <section class="section">
            <div class="container">
                <h1 class="title">
                    Showcasing some library functions.
                </h1>
            </div>
        </div>
        <section class="section">
            <div class="container">
                <h4 class="title is-4">
                    Matches for the 2nd matchday of the Premiere League
                </h4>
                <table class="table is-striped">
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
            </div>
        </section>

        <section class="section">
            <h4 class="title is-4">
                Current standing of the Primera Division
            </h4>
            <table class="table is-striped">
                <tr>
                <th>Position</th>
                <th>TeamName</th>
                <th>GoalDifference</th>
                <th>Points</th>
                </tr>
                <?php foreach ($api->findStandingsByCompetition("PD")->standings as $standing) { 
                        if ($standing->type == 'TOTAL') { 
                            foreach ($standing->table as $standingRow) {
                ?>
                <tr>
                    <td><?php echo $standingRow->position; ?></td>
                    <td><?php echo $standingRow->team->name; ?></td>
                    <td><?php echo $standingRow->goalDifference; ?></td>
                    <td><?php echo $standingRow->points; ?></td>
                </tr>
                <?php }}} ?>
                <tr>
                </tr>
            </table>
        </section>

        
        <?php
            // fetch all available upcoming matches for the next 3 days
            $now = new DateTime();
            $end = new DateTime(); $end->add(new DateInterval('P3D'));
            $response = $api->findMatchesForDateRange($now->format('Y-m-d'), $end->format('Y-m-d'));
        ?>


        <section class="section">
            <h4 class="title is-4">
                Upcoming matches within the next 3 days
            </h4>
            <table class="table is-striped">
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
        </section>


        <?php
            $matches = $api->findHomeMatchesByTeam(67);
        ?>

        <section class="section">
            <h4 class="title is-4">
                This seasons' home matches of Everton FC
            </h4>
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
        </section>

        <?php
            echo "<p><hr><p>";
            // show players of a specific team
            $team = $api->findTeamById(62);
        ?>

        <section class="section">
            <h4 class="title is-4">
                Players of <?php echo $team->name; ?>
            </h4>
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>Position</th>                    
                    <th>Shirtnumber</th>
                    <th>Date of birth</th>
                </tr>
                <?php foreach ($team->squad as $player) { ?>
                <tr>
                    <td><?php echo $player->name; ?></td>
                    <td><?php echo $player->position; ?></td>                    
                    <td><?php echo $player->shirtNumber; ?></td>
                    <td><?php echo $player->dateOfBirth; ?></td>
                </tr>
                <?php } ?>
            </table>
        </section>
            
    </body>
</html>
