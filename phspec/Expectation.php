<?php

class Expectation {
    function __construct($value) {
        $this->value = $value;
    }

    function is_true() {
        $this->equal(true);
    }

    function is_false() {
        $this->equal(false);
    }

    function is_null() {
        $this->equal(null);
    }

    function equal($value) {
        return $this->fail_unless(
            $this->value === $value,
            "Expected ".$this->dump($value).", got ".$this->dump($this->value)
        );
    }

    function dump($value) {
        ob_start();
        var_dump($value);
        return trim(ob_get_clean());
    }

    function is($value) {
        return $this->equal($value);
    }

    function fail_unless($true, $message) {
        $clone = clone($this);
        $this->message = $message;
        $this->failed = ! $true;

        return $clone;
    }

    function failed() {
        $this->is_true;
        return $this->failed;
    }

    function __get($name) {
        return method_exists($this, $name) ? $this->$name() : $this->$name;
    }

    function spec() {
        return $this->spec = Runner::$current->spec;
    }
}
