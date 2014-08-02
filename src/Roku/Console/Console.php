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
        $options = getopt("h:p:d:c:l");

        $host  = isset($options["h"]) ? $options["h"] : "127.0.0.1";
        $port  = isset($options["p"]) ? $options["p"] : 8060;
        $delay = isset($options["d"]) ? $options["d"] : 1.3;

        $http = new \Roku\Utils\HttpConsole();

        $this->roku = new \Roku\Roku($host, $port, $delay);
        $this->roku->setClient($http);

        if(isset($options["l"])) {
            $this->listen();
        }
        elseif(isset($options["c"])) {
            $this->commands($options["c"]);
        }
    }

    public function commands($commands) {
        $commands = explode(" ", $commands);

        //var_dump($commands);die;

        foreach($commands as $command) {
            if(\Roku\Commands\Command::isValidName($command)) {
                $this->Roku->$command();
            }
            else {
                var_dump($command);

            }
        }
    }

    public function listen() {
        system("stty -icanon");
        
        while ($c = (fread(STDIN, 4))) {

/*            echo "\n";
            echo "--------------" . ord($c);
            echo "\n";
            echo "--------------" . strpos($c, '^[');
            echo "\n";
            echo "--------------" . strpos($c, 'B');
            echo "\n";
            echo "--------------" . strpos($c, '[');
            echo "\n";*/

            $key = "";

            //Special Keys
            if(ord($c) == 27) {
                if(strpos($c, 'B') && strpos($c, '[')) {
                    $key = "down";
                }
            }
            else {
                $key = "a";
            }

            //echo "\nRead from STDIN: " . $c . "\ninput# ";
        }
    }


}