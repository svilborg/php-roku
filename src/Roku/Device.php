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

    public function getManufacturerURL() {
        return $manufacturerURL;
    }

    public function setManufacturerURL($manufacturerURL) {
        $this->manufacturerURL = $manufacturerURL;
        return $this;
    }

    public function getModelDescription() {
        return $modelDescription;
    }

    public function setModelDescription($modelDescription) {
        $this->modelDescription = $modelDescription;
        return $this;
    }

    public function getModelName() {
        return $modelName;
    }

    public function setModelName($modelName) {
        $this->modelName = $modelName;
        return $this;
    }

    public function getModelNumber() {
        return $modelNumber;
    }

    public function setModelNumber($modelNumber) {
        $this->modelNumber = $modelNumber;
        return $this;
    }

    public function getModelURL() {
        return $modelURL;
    }

    public function setModelURL($modelURL) {
        $this->modelURL = $modelURL;
        return $this;
    }

    public function getSerialNumber() {
        return $serialNumber;
    }

    public function setSerialNumber($serialNumber) {
        $this->serialNumber = $serialNumber;
        return $this;
    }

    public function getUDN() {
        return $udn;
    }

    public function setUDN($udn) {
        $this->udn = $udn;
        return $this;
    }

    public function getDeviceType() {
        return $deviceType;
    }

    public function setDeviceType($deviceType) {
        $this->deviceType = $deviceType;
        return $this;
    }

    public function getFriendlyName() {
        return $friendlyName;
    }

    public function setFriendlyName($friendlyName) {
        $this->friendlyName = $friendlyName;
        return $this;
    }

    public function getManufacturer() {
        return $manufacturer;
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
}