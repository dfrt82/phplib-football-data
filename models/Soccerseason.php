<?php
/**
 * Soccerseason implements calls to underlying subresources.
 *
 * @author Daniel Freitag <daniel@football-data.org>
 * @date 04.11.2015 
 * 
 */
class Soccerseason {
    
    public $config;   
    public $reqPrefs = array();    
    public $payload;
    
    /**
     * The object gets instantiated with the payload of a request to a specific 
     * soccerseason resource.     
     * 
     * @param type $payload
     */    
    public function __construct($payload) {
        $this->payload = $payload;
        $config = parse_ini_file('config.ini', true);
        
        $this->reqPrefs['http']['method'] = 'GET';
        $this->reqPrefs['http']['header'] = 'X-Auth-Token: ' . $config['authToken'];
    }
    
    /**
     * Function returns all fixtures for the instantiated soccerseason.
     * 
     * @return array of fixture objects
     */    
    public function getAllFixtures() {        
        $uri = $this->payload->_links->fixtures->href;
        $response = file_get_contents($uri, false, stream_context_create($this->reqPrefs)); 
        
        return json_decode($response);
    }
    
    /**
     * Function returns all fixtures for a given matchday.
     * 
     * @param type $matchday
     * @return array of fixture objects
     */    
    public function getFixturesByMatchday($matchday = 1) {        
        $uri = $this->payload->_links->fixtures->href . '/?matchday=' . $matchday;
        
        $response = file_get_contents($uri, false, stream_context_create($this->reqPrefs)); 
        $response = json_decode($response);
        
        return $response->fixtures;
    }
    
    /**
     * Function returns all teams participating in the instantiated soccerseason.
     * 
     * @return array of team objects
     */    
    public function getTeams() {        
        $uri = $this->payload->_links->teams->href;
        $response = file_get_contents($uri, false, stream_context_create($this->reqPrefs)); 
        $response = json_decode($response);
        
        return $response->teams;
    }
    
    /**
     * Function returns the current league table for the instantiated soccerseason.
     * 
     * @return object leagueTable
     */
    public function getLeagueTable() {        
        $uri = $this->payload->_links->leagueTable->href;
        $response = file_get_contents($uri, false, stream_context_create($this->reqPrefs)); 
        
        return json_decode($response);
    }
}
