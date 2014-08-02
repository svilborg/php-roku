<?php
namespace Roku\Utils;

class HttpConsole {

    /**
     * Get Request
     *
     * @param string $uri
     * @return \Httpful\Response
     */
    public function get($uri, $params = array()) {

        if($params) {
            $uri .= "?" . http_build_query($params);
        }

        $this->output("GET : " . $uri);

        return new \Httpful\Response("", "HTTP/1.1 200 OK\r\n", \Httpful\Request::init());
    }

    /**
     * Post Request
     *
     * @param string $uri
     * @return \Httpful\Response
     */
    public function post($uri, $params = array()) {

        if($params) {
            $uri .= "?" . http_build_query($params);
        }

        $this->output("POST : " . $uri);

        return new \Httpful\Response("", "HTTP/1.1 200 OK\r\n", \Httpful\Request::init());
    }

    private function output($string) {
        echo $string;
        echo "\n";
    }
}