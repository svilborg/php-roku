<?php
namespace Tests\Roku;

use Roku;

class CommandTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
       parent::setUp();
    }

    public function testEmpty()
    {
        $this->assertTrue(Roku\Command::hasName("PLAY"));
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
}
