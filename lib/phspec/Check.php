<?php

class Check {
    function __construct($value) {
        $this->value = $value;
    }

    function is_true() {
        return $this->equal(true);
    }

    function is_false() {
        return $this->equal(false);
    }

    function is_null() {
        return $this->equal(null);
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

    function passed() {
        return !$this->failed;
    }

    function __get($name) {
        if (method_exists($this, $name))
            return $this->$name();

        if (function_exists($name))
            return $this->equal($name($this->value));

        return $this->$name;
    }

    function __call($name, $args) {
        if (function_exists($name))
            return $this->equal($name($this->value, $args[0]));
    }

    function spec() {
        return $this->spec = Runner::current()->spec;
    }
}
