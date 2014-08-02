<?php
namespace Roku\Console;

/**
 * Console
 *
 */
class Console {

    /**
     * Roku Instance
     * @var \Roku\Roku
     */
    private $roku;

    public function start() {
        $options = getopt("h:p:d:c:it", array("help"));

        $host  = isset($options["h"]) ? $options["h"] : "127.0.0.1";
        $port  = isset($options["p"]) ? $options["p"] : 8060;
        $delay = isset($options["d"]) ? $options["d"] : 1.3;


        if(isset($options["help"])) {
            $this->help();
        }
        else {
            $this->roku = new \Roku\Roku($host, $port, $delay);

            if(isset($options["t"])) {   
                $this->roku->setClient(new \Roku\Utils\HttpConsole());
            }

            if(isset($options["i"])) {
                try {
                    $this->interactive();
                }
                catch(\Exception $e) {
                    echo "Error " . $e->getMessage();
                    echo "\n";
                }
            }        
            elseif(isset($options["c"])) {
                try {
                    $this->commands($options["c"]);
                }
                catch(\Exception $e) {
                    echo "Error " . $e->getMessage();
                    echo "\n";
                }
            }
        }
    }

    public function commands($commands) {
        $commands = explode(" ", $commands);

        foreach($commands as $command) {
            if(\Roku\Commands\Command::hasName($command)) {
                $this->roku->$command();
            }
            else {
                $this->roku->literals($command);
            }
        }
    }

    public function interactive() {
        system("stty -icanon");
        
        while ($c = (fread(STDIN, 4))) {

            $key = $c;

            echo "\n";

            //Special Keys
            if(ord($c) == 27) {

                if(strpos($c, '[')) {

                    if(strpos($c, 'B')) {
                        $this->roku->down();
                    }
                    else if(strpos($c, 'A')) {
                        $this->roku->up();
                    }
                    else if(strpos($c, 'D')) {
                        $this->roku->left();
                    }
                    else if(strpos($c, 'C')) {
                        $this->roku->right();
                    }
                    else {

                    }
                }

                if(strpos($c, 'O')) {

                    if(strpos($c, 'H')) {
                        $this->roku->home();
                    }
                    elseif(strpos($c, 'F')) {
                        $this->roku->back();
                    }
                }
                
                if(strpos($c, '5')) {
                    $this->roku->fwd();
                }

                if(strpos($c, '6')) {
                    $this->roku->rev();
                }
            }
            else {               
                $this->roku->lit($key);
            }
        }
    }

    private function  help() {

   echo <<<EOT
PHP Roku Console

Usage: roku [OPTION] ..

-h <host>       Host
-p <port>       Port
-d <delay>      Delay between each command
-i              Interactive mode (Listens for keyboard keystrokes)
-c <commands>   Command mode (Specify commands to be executed, Example -c "up down test@gmail.com down select home")
-t              Test Mode (Does not send commands.Just simulates them.)
--help          Shows this help


EOT;
    }


}