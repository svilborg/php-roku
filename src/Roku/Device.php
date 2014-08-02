<?php
namespace Roku;

/**
 * Device
 */
class Device {

    private $deviceType;

    private $friendlyName;

    private $manufacturer;

    private $manufacturerURL;

    private $modelDescription;

    private $modelName;

    private $modelNumber;

    private $modelURL;

    private $serialNumber;

    private $udn;

    private $serviceList;

    /**
     * Get manufacturerURL
     */
    public function getManufacturerURL() {
        return $this->manufacturerURL;
    }

    /**
     * Set manufacturerURL
     *
     * @param string $manufacturerURL
     * @return \Roku\Device
     */
    public function setManufacturerURL($manufacturerURL) {
        $this->manufacturerURL = $manufacturerURL;
        return $this;
    }

    /**
     * Get manufacturerURL
     */
    public function getModelDescription() {
        return $this->modelDescription;
    }

    /**
     * Set modelDescription
     *
     * @param string $modelDescription
     * @return \Roku\Device
     */
    public function setModelDescription($modelDescription) {
        $this->modelDescription = $modelDescription;
        return $this;
    }

    /**
     * Set modelName
     */
    public function getModelName() {
        return $this->modelName;
    }

    /**
     * Set modelName
     *
     * @param string $modelName
     * @return \Roku\Device
     */
    public function setModelName($modelName) {
        $this->modelName = $modelName;
        return $this;
    }

    /**
     * Get modelNumber
     */
    public function getModelNumber() {
        return $this->modelNumber;
    }

    /**
     * Set modelNumber
     *
     * @param string $modelNumber
     * @return \Roku\Device
     */
    public function setModelNumber($modelNumber) {
        $this->modelNumber = $modelNumber;
        return $this;
    }

    /**
     * Get modelURL
     */
    public function getModelURL() {
        return $this->modelURL;
    }

    /**
     * Set modelURL
     *
     * @param string $modelURL
     * @return \Roku\Device
     */
    public function setModelURL($modelURL) {
        $this->modelURL = $modelURL;
        return $this;
    }

    /**
     * Get setModelURL
     *
     * @return string
     */
    public function getSerialNumber() {
        return $this->serialNumber;
    }

    /**
     * Set serialNumber
     *
     * @param string $serialNumber
     * @return \Roku\Device
     */
    public function setSerialNumber($serialNumber) {
        $this->serialNumber = $serialNumber;
        return $this;
    }

    /**
     * Get UDN
     *
     * @return string
     */
    public function getUDN() {
        return $this->udn;
    }

    /**
     * Set udn
     *
     * @param string $udn
     * @return \Roku\Device
     */
    public function setUDN($udn) {
        $this->udn = $udn;
        return $this;
    }

    /**
     * Get Device Type
     *
     * @return string
     */
    public function getDeviceType() {
        return $this->deviceType;
    }

    /**
     * Set deviceType
     *
     * @param string $deviceType
     * @return \Roku\Device
     */
    public function setDeviceType($deviceType) {
        $this->deviceType = $deviceType;
        return $this;
    }

    public function getFriendlyName() {
        return $this->friendlyName;
    }

    /**
     * Set friendlyName
     *
     * @param string $friendlyName
     * @return \Roku\Device
     */
    public function setFriendlyName($friendlyName) {
        $this->friendlyName = $friendlyName;
        return $this;
    }

    /**
     * Get Manufacturer
     *
     * @return string
     */
    public function getManufacturer() {
        return $this->manufacturer;
    }

    /**
     * Set Manufacturer
     *
     * @param string $manufacturer
     * @return \Roku\Device
     */
    public function setManufacturer($manufacturer) {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    /**
     * Get serviceList
     *
     * @return string
     */
    public function getServiceList() {
        return $this->serviceList;
    }

    /**
     * Init from Xml
     *
     * @param \SimpleXMLElement $xml
     * @return \Roku\Device
     */
    public function init(\SimpleXMLElement $xml) {
        $xml = $this->xml2Array($xml);

        foreach ($xml as $name => $value) {
            if ($name == "UDN") {
                $name = strtolower($name);
            }

            $this->$name = $value;
        }

        return $this;
    }

    /**
     * XML To Array
     *
     * @param \SimpleXMLElement $xml
     * @return array
     */
    function xml2Array(\SimpleXMLElement $xml) {
        // $xml = simplexml_load_string($string, 'SimpleXMLElement', LIBXML_NOCDATA);
        $array = json_decode(json_encode($xml), TRUE);

        return $array;
    }
}