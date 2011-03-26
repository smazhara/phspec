<?php
namespace Phspec;

class Stubber {
    function __construct($obj) {
        $this->stub = new Stub($obj);
    }

    function __call($method, $args) {
        if ($method == 'return') {
            $this->stub->stub_it(array_shift($args));
            return $this->stub;
        } else {
            $this->stub->stub_it($method, $args);
            return $this;
        }
    }

    function __get($method) {
        return $this->$method();
    }
}
