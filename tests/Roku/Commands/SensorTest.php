<?php
namespace Tests\Roku;

use \Roku\Commands\Sensor;

class SensorTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
       parent::setUp();
    }

    public function testEmpty()
    {
        $this->assertTrue(Sensor::hasName("rotation"));
        $this->assertFalse(Sensor::hasName("nosensor"));
    }
}
