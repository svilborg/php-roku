<?php
namespace Roku;

/**
 * Roku Client
 */
class Roku {

    private $host;

    private $port;

    private $client;

    /**
     * Init
     *
     * @param string $host Host
     * @param number $port Port Number
     */
    public function __construct($host, $port = 8060) {
        $this->host = $host;
        $this->port = $port;
        $this->client = new \Roku\Utils\Http();
    }

    public function setClient ($client) {
        $this->client = $client;
    }

    public function __call($name, $fargs) {

        if(\Roku\Command::hasName($name)) {           
            $this->keypress($name);
        }
        else {
            die("Not Found");
        }
    }

    public function keypress($command) {
        $thid->client->get($this->getUri("keypress", $command));
    }
    
    public function keydown($command) {
        $thid->client->get($this->getUri("keydown", $command));
    }
    
    public function keyup($command) {
        $thid->client->get($this->getUri("keyup", $command));
    }

    public function apps() {
        $thid->client->get($this->getUri("keyup", $command));
    }

    public function icon() {
        $thid->client->get($this->getUri("keyup", $command));
    }

    private function getUri() {

        $uri = $this->host . ":" . $this->port;

        foreach(func_get_args() as $part) {
            $uri .= '/' . $part;
        }

        return $uri;
    }
}