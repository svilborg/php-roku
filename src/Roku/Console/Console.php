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
        $options = getopt("h:p:d:c:i", array("help"));

        $host  = isset($options["h"]) ? $options["h"] : "127.0.0.1";
        $port  = isset($options["p"]) ? $options["p"] : 8060;
        $delay = isset($options["d"]) ? $options["d"] : 1.3;

        $http = new \Roku\Utils\HttpConsole();

        $this->roku = new \Roku\Roku($host, $port, $delay);
        $this->roku->setClient($http);

        if(isset($options["help"])) {
            $this->help();
        }
        elseif(isset($options["i"])) {
            $this->interactive();
        }        
        elseif(isset($options["c"])) {
            $this->commands($options["c"]);
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
                    echo $c . "CC";die;
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

    }


}