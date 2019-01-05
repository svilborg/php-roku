<?php
namespace Tests\Roku;

use \Roku\Commands\Sensor;
use PHPUnit\Framework\TestCase;

class SensorTest extends TestCase
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
