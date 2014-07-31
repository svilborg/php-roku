<?php
namespace Roku\Utils;

class Http {

    public function get($uri) {
        $response = \Httpful\Request::get($uri)->send();

        return $respone;
    }


    public function post($uri) {
        $response = \Httpful\Request::get($uri)->send();

        return $respone;
    }
}