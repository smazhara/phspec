<?php

class Spec {
    public $expectations = array();

    function __construct($name, $function) {
        Runner::$current->spec = $this;
        $this->name = $name;
        $function();
    }

    function run() {
        $function = $this->function;
        $function();
    }

    function add(Expectation $expectation) {
        $this->expectations[] = $expectation;
    }

    function failed() {
        return $this->failed = !!$this->failed_expectations;
    }

    function failed_expectations() {
        $this->failed_expectations = array();
        foreach ($this->expectations as $expectation) {
            if ($expectation->failed)
                $this->failed_expectations[] = $expectation;
        }
        return $this->failed_expectations;
    }

    function __get($name) {
        return method_exists($this, $name) ? $this->$name() : $this->$name;
    }
}
