<?php
namespace Roku;

/**
 * Roku Client
 */
class Roku {

    /**
     * Host
     * @var string
     */
    private $host;

    /**
     * Port
     * @var integer
     */
    private $port;

    /**
     * Roku Http Client
     * @var \Roku\Utils\Http
     */
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

    /**
     * Set Client Instance
     * @param \Roku\Utils\Http $client
     */
    public function setClient($client) {
        $this->client = $client;
    }

    /**
     * Catchase all function calls
     *
     * @param string $name Function name
     * @param array $fargs Arguments
     */
    public function __call($name, $fargs) {

        if (\Roku\Command::hasName($name)) {
            if (strtoupper(\Roku\Command::LIT) == strtoupper($name)) {

                $command = \Roku\Command::LIT . "_" . $fargs[0];
                $response = $this->keypress($command);
            } else {
                $response = $this->keypress($name);
            }

        } else {
            die("Not Found");
        }
    }

    public function keypress($command) {
        $response = $this->client->post($this->getUri("keypress", $command));

        if($response->code !== 200) {
            throw new Exception("Command Error");
        }

        return $response->raw_body;
    }

    public function keydown($command) {
        $response = $this->client->post($this->getUri("keydown", $command));

        if($response->code !== 200) {
            throw new Exception("Command Error");
        }

        return $response->raw_body;
    }

    public function keyup($command) {
        $result = $this->client->post($this->getUri("keyup", $command));

        if($result->code !== 200) {
            throw new Exception("Command Error");
        }

        return $response->raw_body;
    }

    public function apps() {
        $response = $this->client->get($this->getUri("query", "apps"));

        if($response->code !== 200) {
            throw new Exception("Command Error");
        }

        return $response->body;
    }

    public function icon() {
        $response = $this->client->get($this->getUri("query", "icon", $id));

        if($response->code !== 200) {
            throw new Exception("Command Error");
        }

        return $response->raw_body;
    }

    private function getUri() {
        $uri = $this->host . ":" . $this->port;

        foreach (func_get_args() as $part) {
            $uri .= '/' . $part;
        }

        return $uri;
    }
}