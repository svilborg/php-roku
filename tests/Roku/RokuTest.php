<?php
namespace Tests\Roku;

use Roku;
use \Httpful\Request;

class RokuTest extends \PHPUnit_Framework_TestCase
{

    public function testEmpty()
    {
        $this->assertTrue(true);


        $host = "http://192.168.72.34";

        $roku = new \Roku\Roku($host);

        //$roku->home();

        echo $roku->apps();

    }

}
