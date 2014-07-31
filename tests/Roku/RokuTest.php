<?php
namespace Tests\Roku;

use Roku;
use \Httpful\Request;

class RokuTest extends \PHPUnit_Framework_TestCase
{

    public function testEmpty()
    {
        $this->assertTrue(true);

/*        $request = Request::get("http://google.com")->send();

        echo $request->code;die;*/

        $roku = new \Roku\Roku("127.0.0.1");

        $roku->home();

    }

}
