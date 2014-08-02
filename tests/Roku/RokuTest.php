<?php
namespace Tests\Roku;

use Roku;
use \Httpful\Request;

class RokuTest extends \PHPUnit_Framework_TestCase
{

    public function setUp() {
        $host = "http://127.0.0.1";
        $http = $this->getHttpInstance();

        $this->roku = new \Roku\Roku($host);
        $this->roku->setClient($http);

        parent::setUp();
    }

    public function testCommands()
    {
        $this->assertNotNull($this->roku->home());
        $this->assertNotNull($this->roku->up());
        $this->assertNotNull($this->roku->down());
        $this->assertNotNull($this->roku->select());
    }

    public function testErrors()
    {
        $this->setExpectedException(
            '\Roku\Exception'
            );

        $this->assertNotNull($this->roku->rotate());
    }

    public function testApps()
    {
        $host = "http://127.0.0.1";
        $http = $this->getHttpXmlInstance();

        $this->roku = new \Roku\Roku($host);
        $this->roku->setClient($http);

        $apps = $this->roku->apps();

        $this->assertEquals(31012, $apps[0]->getId());
        $this->assertEquals("1.4.14", $apps[0]->getVersion());
        $this->assertEquals("Movies and TV Shows", $apps[0]->getName());

        $this->assertCount(43, $apps);
    }

    public function testDevice()
    {
        $host = "http://127.0.0.1";
        $http = $this->getHttpXmlInstance("roku.xml");

        $this->roku = new \Roku\Roku($host);
        $this->roku->setClient($http);

        $device = $this->roku->device();

        $this->assertEquals("urn:roku-com:device:player:1-0", $device->getDeviceType());
        $this->assertEquals("Roku Streaming Player", $device->getFriendlyName());
        $this->assertEquals("Roku", $device->getManufacturer());
        $this->assertEquals("http://www.roku.com/", $device->getManufacturerURL());
        $this->assertEquals("Roku Streaming Player Network Media", $device->getModelDescription());
        $this->assertEquals("Roku Streaming Player 4200X", $device->getModelName());
        $this->assertEquals("4200X", $device->getModelNumber());
        $this->assertEquals("http://www.roku.com/", $device->getModelURL());
        $this->assertEquals("uuid:8888888-8888-888-8888-b83e59cfd25f", $device->getUDN());
        $this->assertEquals("1GN111111111", $device->getSerialNumber());
    }

    public function getHttpInstance () {
        $headers =
        "HTTP/1.1 200 OK
        Content-Length: 0
        Server: Roku UPnP/1.0 MiniUPnPd/1.4\r\n";

        $response = new \Httpful\Response("", $headers, \Httpful\Request::init());

        $http = $this->getMock('\Roku\Utils\Http');

        // Configure the stub.
        $http->expects($this->any())
        ->method('get')
        ->will($this->returnValue($response));

        $http->expects($this->any())
        ->method('post')
        ->will($this->returnValue($response));

        return $http;
    }

    public function getHttpXmlInstance ($file = "apps.xml") {
        $headers =
        "HTTP/1.1 200 OK
        Content-Length: 0
        Server: Roku UPnP/1.0 MiniUPnPd/1.4\r\n";

        $response = new \Httpful\Response( file_get_contents(__DIR__."/../data/" . $file), $headers, \Httpful\Request::init());

        $http = $this->getMock('\Roku\Utils\Http');

        // Configure the stub.
        $http->expects($this->any())
        ->method('get')
        ->will($this->returnValue($response));

        $http->expects($this->any())
        ->method('post')
        ->will($this->returnValue($response));

        return $http;
    }
}
