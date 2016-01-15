<?php
  include 'FootballData.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>phplib football-data.org</title>
        <link href="/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div class="container">
                <div class="page-header">
                    <h1>Showcasing some library functions...</h1>
                </div>
                <?php
                // Create instance of API class
                $api = new FootballData();
                // fetch and dump summary data for premier league' season 2015/16
                $soccerseason = $api->getSoccerseasonById(398);
                echo "<p><hr><p>"; ?>
                <h3>Fixtures for the 1st matchday of <?php echo $soccerseason->payload->caption; ?></h3>
                <table class="table table-striped">
                    <tr>
                    <th>HomeTeam</th>
                    <th></th>
                    <th>AwayTeam</th>
                    <th colspan="3">Result</th>
                    </tr>
                    <?php foreach ($soccerseason->getFixturesByMatchday(1) as $fixture) { ?>
                    <tr>
                        <td><?php echo $fixture->homeTeamName; ?></td>
                        <td>-</td>
                        <td><?php echo $fixture->awayTeamName; ?></td>
                        <td><?php echo $fixture->result->goalsHomeTeam; ?></td>
                        <td>:</td>
                        <td><?php echo $fixture->result->goalsAwayTeam; ?></td>
                    </tr>
                    <?php } ?>
                </table>
            <?php
                echo "<p><hr><p>";
                // fetch all available upcoming fixtures for the next week and display
                $now = new DateTime();
                $end = new DateTime(); $end->add(new DateInterval('P7D'));
                $response = $api->getFixturesForDateRange($now->format('Y-m-d'), $end->format('Y-m-d'));
            ?>
            <h3>Upcoming fixtures next 7 days</h3>
                <table class="table table-striped">
                    <tr>
                        <th>HomeTeam</th>
                        <th></th>
                        <th>AwayTeam</th>
                        <th colspan="3">Result</th>
                    </tr>
                    <?php foreach ($response->fixtures as $fixture) { ?>
                    <tr>
                        <td><?php echo $fixture->homeTeamName; ?></td>
                        <td>-</td>
                        <td><?php echo $fixture->awayTeamName; ?></td>
                        <td><?php echo $fixture->result->goalsHomeTeam; ?></td>
                        <td>:</td>
                        <td><?php echo $fixture->result->goalsAwayTeam; ?></td>
                    </tr>
                    <?php } ?>
                </table>

            <?php
                echo "<p><hr><p>";
                // search for desired team
                $searchQuery = $api->searchTeam(urlencode("Real Madrid"));
                // var_dump searchQuery and inspect for results
                $response = $api->getTeamById($searchQuery->teams[0]->id);
                $fixtures = $response->getFixtures('home')->fixtures;
            ?>
                <h3>All home matches of Real Madrid:</h3>
                <table class="table table-striped">
                    <tr>
                        <th>HomeTeam</th>
                        <th></th>
                        <th>AwayTeam</th>
                        <th colspan="3">Result</th>
                    </tr>
                    <?php foreach ($fixtures as $fixture) { ?>
                    <tr>
                        <td><?php echo $fixture->homeTeamName; ?></td>
                        <td>-</td>
                        <td><?php echo $fixture->awayTeamName; ?></td>
                        <td><?php echo $fixture->result->goalsHomeTeam; ?></td>
                        <td>:</td>
                        <td><?php echo $fixture->result->goalsAwayTeam; ?></td>
                    </tr>
                    <?php } ?>
                </table>



            <?php
                echo "<p><hr><p>";
                // fetch players for a specific team
                $team = $api->getTeamById($searchQuery->teams[0]->id);
            ?>
            <h3>Players of <?php echo $team->_payload->name; ?></h3>
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Jersey Number</th>
                    <th>Date of birth</th>
                </tr>
                <?php foreach ($team->getPlayers() as $player) { ?>
                <tr>
                    <td><?php echo $player->name; ?></td>
                    <td><?php echo $player->position; ?></td>
                    <td><?php echo $player->jerseyNumber; ?></td>
                    <td><?php echo $player->dateOfBirth; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </body>
</html>
