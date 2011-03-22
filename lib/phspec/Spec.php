<?php

class Spec {
    public $checks = array();

    function __construct($name, $function) {
        Runner::current()->spec = $this;
        $this->name = $name;
        if ($function)
            $function();
    }

    function run() {
        $function = $this->function;
        $function();
    }

    function add($check) {
        $this->checks[] = $check;
    }

    function failed() {
        return $this->failed = !!$this->failed_checks;
    }

    function failed_checks() {
        $this->failed_checks = array();
        foreach ($this->checks as $expectation) {
            if ($expectation->failed)
                $this->failed_checks[] = $expectation;
        }
        return $this->failed_checks;
    }

    function __get($name) {
        return method_exists($this, $name) ? $this->$name() : $this->$name;
    }
}
