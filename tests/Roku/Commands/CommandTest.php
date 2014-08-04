<?php
namespace Tests\Roku;

use \Roku\Commands\Command;

class CommandTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
       parent::setUp();
    }

    public function testEmpty()
    {
        $this->assertTrue(Command::hasName("PLAY"));
        $this->assertTrue(Command::hasValue("Play"));
        
        $this->assertFalse(Command::hasName("nosuch"));
        $this->assertTrue(Command::hasName("PLAY"));
    }
}
