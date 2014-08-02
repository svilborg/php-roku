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

        if($params) {
            $uri .= "?" . http_build_query($params);
        }

        $response = \Httpful\Request::get($uri)->send();

        return $response;
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

        $response = \Httpful\Request::post($uri)->send();

        return $response;
    }
}