<?php
/**
 * Team class implements calls to underlying subresources.
 *
 * @author Daniel Freitag <daniel@football-data.org>
 * @date 11.11.2015
 *
 */
class Team {

    public $config;
    public $reqPrefs = array();

    public $_payload;

    /**
     * An object is instantiated with the payload of a request to a team resource.
     *
     * @param type $payload
     */
    public function __construct($payload) {
        $this->_payload = $payload;
        $config = parse_ini_file('config.ini', true);

        $this->reqPrefs['http']['method'] = 'GET';
        $this->reqPrefs['http']['header'] = 'X-Auth-Token: ' . $config['authToken'];
    }

    /**
     * Function returns all fixtures for the team for this season.
     *
     * @param string $venue
     * @return array of stdObjects representing fixtures
     */
    public function getFixtures($venue = "", $timeFrame = "") {
        $uri = $this->_payload->_links->fixtures->href . '/?venue=' . $venue . '&timeFrame=' . $timeFrame;
        $response = file_get_contents($uri, false, stream_context_create($this->reqPrefs));

        return json_decode($response);
    }

    /**
     * Function returns all players of the team
     *
     * @return array of fixture objects
     */
    public function getPlayers() {
        $uri = $this->_payload->_links->players->href;

        $response = file_get_contents($uri, false, stream_context_create($this->reqPrefs));
        $response = json_decode($response);

        return $response->players;
    }
}
