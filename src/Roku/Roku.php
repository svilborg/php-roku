<?php
namespace Roku;

use \Roku\Commands\Command;

/**
 * Roku Client
 */
class Roku {

    /**
     * Host
     *
     * @var string
     */
    private $host;

    /**
     * Port
     *
     * @var integer
     */
    private $port;

    /**
     * Roku Http Client
     *
     * @var \Roku\Utils\Http
     */
    private $client;

    /**
     * Init
     *
     * @param string $host
     *            Host
     * @param number $port
     *            Port Number
     */
    public function __construct($host, $port = 8060) {
        $this->host = $host;
        $this->port = $port;
        $this->client = new \Roku\Utils\Http();
    }

    /**
     * Set Client Instance
     *
     * @param \Roku\Utils\Http $client
     */
    public function setClient($client) {
        $this->client = $client;
    }

    /**
     * Catchase all function calls
     *
     * @param string $name
     *            Function name
     * @param array $fargs
     *            Arguments
     */
    public function __call($name, $fargs) {
        if (Command::hasName($name)) {
            if (strtoupper(Command::LIT) == strtoupper($name)) {

                $command = Command::LIT . "_" . $fargs[0];
                return $this->keypress($command);
            } else {
                return $this->keypress($name);
            }
        } else {
            throw new Exception("Command Not Found");
        }
    }

    /**
     * Keypress
     *
     * @param string $command
     *            Command name
     * @throws Exception
     */
    public function keypress($command) {
        $response = $this->client->post($this->getUri("keypress", $command));

        if ($response->code !== 200) {
            throw new Exception("Command Error - " . $command, $response->code);
        }

        return $response->raw_body;
    }

    /**
     * KeEydown
     *
     * @param string $command
     *            Command name
     * @throws Exception
     */
    public function keydown($command) {
        $response = $this->client->post($this->getUri("keydown", $command));

        if ($response->code !== 200) {
            throw new Exception("Command Error - " . $command, $response->code);
        }

        return $response->raw_body;
    }

    /**
     * Keyup
     *
     * @param string $command
     *            Command name
     * @throws Exception
     */
    public function keyup($command) {
        $result = $this->client->post($this->getUri("keyup", $command));

        if ($result->code !== 200) {
            throw new Exception("Command Error - " . $command, $response->code);
        }

        return $response->raw_body;
    }

    /**
     * Get Device Information
     *
     * @throws Exception
     * @return \Roku\Device
     */
    public function device() {
        $response = $this->client->get($this->getUri());

        if ($response->code !== 200) {
            throw new Exception("Command Error - device", $response->code);
        }

        $deviceElement = simplexml_load_string($response->body);

        if ($deviceElement === false) {
            throw new Exception("Parse Error");
        }

        $device = new Device();

        $device->init($deviceElement->device);

        return $device;
    }

    /**
     * Get Applications
     *
     * @throws Exception
     * @return array:\Roku\Application
     */
    public function apps() {
        $response = $this->client->get($this->getUri("query", "apps"));

        if ($response->code !== 200) {
            throw new Exception("Command Error - apps", $response->code);
        }

        $apps = simplexml_load_string($response->body);

        if ($apps === false) {
            throw new Exception("Parse Error");
        }

        $result = array();

        foreach ($apps as $app) {

            $id = (string) $app->attributes()->id;
            $version = (string) $app->attributes()->version;
            $name = (string) $app;

            $result[] = new Application($id, $version, $name);
        }

        return $result;
    }

    /**
     * Get Application Icon
     *
     * @param Application $app
     * @throws Exception
     */
    public function icon(Application $app) {
        $response = $this->client->get($this->getUri("query", "icon", $app->getId()));

        if ($response->code !== 200) {
            throw new Exception("Command Error - icon");
        }

        return $response->raw_body;
    }

    /**
     * Launch Application
     *
     * @param Application $app
     *            Application
     * @param array $params
     *            Params
     * @throws Exception
     *
     * @return string
     */
    public function launch(Application $app, $params = array()) {
        $response = $this->client->get($this->getUri("launch", $app->getId()), $params);

        if ($response->code !== 200) {
            throw new Exception("Command Error - launch");
        }

        return $response->raw_body;
    }

    /**
     * Send raw input command
     *
     * @param array $params
     * @throws Exception
     * @return string
     */
    public function input($params = array()) {
        $response = $this->client->get($this->getUri("input"), $params);

        if ($response->code !== 200) {
            throw new Exception("Command Error - input");
        }

        return $response->raw_body;
    }

    /**
     * Build uri from input args
     *
     * @return string
     */
    private function getUri() {
        $uri = $this->host . ":" . $this->port;

        foreach (func_get_args() as $part) {
            $uri .= '/' . $part;
        }

        return $uri;
    }
}