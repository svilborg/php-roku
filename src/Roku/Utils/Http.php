<?php
namespace Roku\Utils;

class Http {

    /**
     * Get Request
     *
     * @param string $uri
     * @return \Httpful\Response
     */
    public function get($uri) {
        $response = \Httpful\Request::get($uri)->send();

        return $response;
    }

    /**
     * Post Request
     *
     * @param string $uri
     * @return \Httpful\Response
     */
    public function post($uri) {
        $response = \Httpful\Request::post($uri)->send();

        return $response;
    }
}