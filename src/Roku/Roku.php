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
            if(strtoupper(\Roku\Command::LIT) == strtoupper($name)) {

                $command = \Roku\Command::LIT . "_" . $fargs[0];
                $this->keypress($command);
            }   
            else {
                $this->keypress($name);
            } 
        }
        else {
            die("Not Found");
        }
    }

    public function keypress($command) {
        return $thid->client->post($this->getUri("keypress", $command));
    }
    
    public function keydown($command) {
        return $thid->client->post($this->getUri("keydown", $command));
    }
    
    public function keyup($command) {
        return $thid->client->post($this->getUri("keyup", $command));
    }

    public function apps() {
        return $thid->client->get($this->getUri("query/apps"));
    }

    public function icon() {
        return $thid->client->get($this->getUri("query/icon"));
    }

    private function getUri() {

        $uri = $this->host . ":" . $this->port;

        foreach(func_get_args() as $part) {
            $uri .= '/' . $part;
        }

        return $uri;
    }
}