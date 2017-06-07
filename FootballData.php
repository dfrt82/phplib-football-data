<?php

  spl_autoload_register(function ($v) {
    require_once "models/$v.php";
});

/**
 * This service class encapsulates football-data.org's RESTful API.
 *
 * @author Daniel Freitag <daniel@football-data.org>
 * @date 04.11.2015
 *
 * @author Al Nmeri <vainglories[at]gmail.com>
 * @date 07/06/17
 * 
 */
class FootballData {
    
    public $config;
    public $baseUri;
    public $reqPrefs = array();
        
    public function __construct() {
        $this->config = parse_ini_file('config.ini', true);

	// some lame hint for the impatient
	if($this->config['authToken'] == 'YOUR_AUTH_TOKEN' || !isset($this->config['authToken'])) {
		exit('Get your API-Key first and edit config.ini');
	}
        
        $this->baseUri = $this->config['baseUri']; 
        
        $this->reqPrefs['http']['method'] = 'GET';
        $this->reqPrefs['http']['header'] = 'X-Auth-Token: ' . $this->config['authToken'];
    }
    
    /**
     * Function returns a specific soccer season identified by an id.
     * 
     * @param Integer $id
     * @return \Soccerseason object
     */        
    public function getSoccerSeasonById($id) {
        return new Soccerseason($this->endRes("soccerseasons/$id"));
    }
    
    /**
     * Function returns one unique team identified by a given id.
     * 
     * @param int $id
     * @return stdObject team
     */    
    public function getTeamById($id) { 
        return new Team($this->endRes("teams/$id"));
    }
    
    /**
     * Function returns all teams matching a given keyword.
     * 
     * @param string $keyword
     * @return list of team objects
     */    
    public function searchTeam($keyword) {
        return $this->endRes("teams/?name=$keyword");
    }

    public function fetchFixturesFor($date='n1') {
        return $this->endRes("fixtures?timeFrame=$date");
    }

    public function headToHead(int $fixtureID, int $count) {
        return $this->endRes("fixtures/$fixtureID?head2head=$count");
    }
    
    public function getFixtureId($home, $away, $date) {
        $id;
        foreach ($this->fetchFixturesFor($date)->fixtures as $key => $fixtures) {
            if ($fixtures->homeTeamName == $home && $fixtures->awayTeamName == $away) {
                $id = @end(explode('/', $fixtures->_links->self->href));
            }
        }
        return $id;
    }

    public function endRes ($resource) {
        $response = file_get_contents($this->baseUri . $resource, false, stream_context_create($this->reqPrefs));
        
        return json_decode($response);
    }
}
