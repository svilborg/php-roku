<?php
namespace Roku;

/**
 * Application
 */
class Application {

    /**
     * Id
     * @var string
     */
    private $id;

    /**
     * Version
     * @var string
     */
    private $version;

    /**
     * Name
     * @var string
     */
    private $name;

    /**
     * Init
     *
     * @param string $id Id
     * @param string $version Version
     * @param string $name Name
     */
    public function __construct($id, $version = "", $name = "") {
        $this->id = $id;
        $this->version = $version;
        $this->name = $name;
    }

    /**
     * Get Id
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get Version
     * @return string
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * Get Name
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set Application Id
     *
     * @param string $id
     * @return \Roku\Application
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Set Version
     * @param string $version
     * @return \Roku\Application
     */
    public function setVersion($version) {
        $this->version = $version;
        return $this;
    }

    /**
     * Set Application Name
     * @param string $name
     * @return \Roku\Application
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }
}