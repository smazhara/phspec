<?php
namespace Phspec;

class Stub {
    private $method;
    private $stubs;

    function __construct($obj) {
        $this->obj = $obj;
    }

    function __call($method, $args = array()) {
        if ($this->stub_exists($method))
            return $this->stub($method, $args);

        if ($this->method_exists($method))
            return $this->delegate($method, $args);

    }

    function __get($method) {
        return $this->$method();
    }

    function delegate($method, $args) {
        return call_user_func_array(array($this->obj, $method), $args);
    }

    function method_exists($method) {
        return method_exists($this->obj, $method);
    }

    function stub_exists($method) {
        return !!@$this->stubs[$method];
    }

    function stub($method, $args) {
        return $this->stubs[$method][$this->hash_it($args)];
    }

    function stub_it(/*$method, $args[]*/) {
        $args = func_get_args();
        if (@$this->method) {
            $return = array_shift($args);
            $this->stubs[$this->method][$this->args] = $return;
            unset($this->method);
        } else {
            $this->method = array_shift($args);
            $this->args = $this->hash_it($args[0]);

        }
    }

    function hash_it($args) {
        return md5(serialize($args));
    }
}
