<?php
namespace Roku;

use \Roku\Commands\Command;
use \Roku\Commands\Sensor;
use \Roku\Commands\Touch;

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
     * Delay
     *
     * @var float
     */
    private $delay;

    /**
     * Init
     *
     * @param string $host Host
     * @param number $port Port Number
     */
    public function __construct($host, $port = null, $delay = 0) {
        $this->host   = $host;
        $this->port   = $port ? $port : 8060;
        $this->delay  = $delay;
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
     * @param string $name Function name
     * @param array $fargs Arguments
     */
    public function __call($name, $fargs) {


        if (Command::hasName($name)) {
            if (strtoupper(Command::LIT) == strtoupper($name)) {

                $command = Command::LIT . "_" . ($fargs[0] ? urlencode($fargs[0]) : "");
                
                return $this->keypress($command);
            } 
            else {
                return $this->keypress($name);
            }
        }
        elseif (Sensor::hasName($name)) {

            $params = array();
            $axis   = array("x", "y", "z");

            foreach($fargs as $i => $value) {
                $params[strtolower($name) . "." . $axis[$i]] = $value; 
            }

            return $this->input($params);
        }
        else {
            throw new Exception("Command Not Found");
        }
    }

    /**
     * Send text as multiple literal calls
     *
     * @param string $text Text
     * @throws Exception
     * @return void
     */
    public function literals($text) {
        $chars = str_split($text);

        foreach ($chars as $char) {
            $this->lit($char);
        }
    }

    /**
     * Keypress
     *
     * @param string $command Command name
     * @throws Exception
     */
    public function keypress($command) {
        $response = $this->client->post($this->getUri("keypress", $command));

        $this->delay();

        if ($response->code !== 200) {
            throw new Exception("Command Error - " . $command, $response->code);
        }

        return $response->raw_body;
    }

    /**
     * Keydown
     *
     * @param string $command Command name
     * @throws Exception
     */
    public function keydown($command) {
        $response = $this->client->post($this->getUri("keydown", $command));

        $this->delay();

        if ($response->code !== 200) {
            throw new Exception("Command Error - " . $command, $response->code);
        }

        return $response->raw_body;
    }

    /**
     * Keyup
     *
     * @param string $command Command name
     * @throws Exception
     */
    public function keyup($command) {
        $response = $this->client->post($this->getUri("keyup", $command));

        $this->delay();

        if ($response->code !== 200) {
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
        $response = $this->client->post($this->getUri("launch", $app->getId()), $params);

        if ($response->code !== 200) {
            if ($response->code == 204) {
                throw new Exception("Application already launched");
            }
            elseif ($response->code == 204)  {
                throw new Exception("Application Not Found");
            }
            else {
                throw new Exception("Command Error - launch");    
            }            
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
        $response = $this->client->post($this->getUri("input"), $params);

        if ($response->code !== 200) {
            throw new Exception("Command Error - input");
        }

        return $response->raw_body;
    }

   /**
     * Touch
     *
     * @param string $x
     * @param string $y
     * @param string $op
     * 
     * @throws Exception
     * @return string
     */
    public function touch($x =0, $y = 0, $op = Touch::DOWN) {
        $params = array();

        if (!Touch::hasName($op)) {
            throw new Exception("Touch Option Not Found - " . $op);
        }

        $params = array(
            "touch.0.x"  => $x,
            "touch.0.y"  => $y,
            "touch.0.op" => $op
        );

        return $this->input($params);
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

    /**
     * Execute sleep
     * @return void
     */
    private function delay() {
        if($this->delay > 0) {  
            sleep($this->delay);
        }
    }

    /**
     * toString
     * @return string
     */
    public function __toString() {
        return "Roku [" . $this->host . ":" . $this->port ."]";
    }
}