<?php
namespace Roku\Utils;

class Http {

    /**
     * Get Request
     *
     * @param string $uri
     * @return \Httpful\Response
     */
    public function get($uri, $params = array()) {
        $uri = $this->buildUri($uri, $params);

        return = \Httpful\Request::get($uri)->send();
    }

    /**
     * Post Request
     *
     * @param string $uri
     * @return \Httpful\Response
     */
    public function post($uri, $params = array()) {
        $uri = $this->buildUri($uri, $params);

        return \Httpful\Request::post($uri)->send();
    }

    private function  buildUri ($uri, $params = array()) {
        if($params) {
            return $uri . "?" . http_build_query($params);
        }

        return $uri;
    }
}