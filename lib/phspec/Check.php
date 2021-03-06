<?php
namespace Phspec;

class Check {
    private $not = false;

    function __construct($value) {
        $this->value = $value;
    }

    function true() {
        return $this->is(true);
    }

    function false() {
        return $this->is(false);
    }

    function null() {
        return $this->is(null);
    }

    function match($regex) {
        return $this->fail_unless(
            preg_match($regex, $this->value),
            "Expected $this->dump, to match `$regex`"
        );
    }

    function throws($expected = 'Exception') {
        $closure = $this->value;
        try {
            $closure();
            return $this->fail("Exception expected, but none thrown");
        } catch (\Exception $e) {
            $actual = get_class($e);
            if ($actual == $expected)
                return $this->pass;

            return $this->fail(
                "Exception `$expected` is expected, " .
                "but `$actual` is thrown");
        }
    }

    function negate() {
        $this->not = true;
    }

    function equal($value) {
        return $this->fail_unless(
            $this->value == $value,
            "Expected ".$this->dump($value).", got ".$this->dump($this->value)
        );
    }

    function dump() {
        $args = func_get_args();
        $value = $args ? $args[0] : $this->value;

        ob_start();
        var_dump($value);
        return trim(ob_get_clean());
    }

    function is($value) {
        return $this->fail_unless(
            $this->value === $value,
            "Expected ".$this->dump($value).", got ".$this->dump($this->value)
        );
    }

    function is_not($value) {
        return $this->fail_unless(
            $this->value !== $value,
            "Expected ".$this->dump($value).", got ".$this->dump($this->value)
        );
    }

    function fail_unless($true, $message) {
        $clone = clone($this);
        if (@$this->not)
            $true = !$true;
        if (! $true)
            $this->message = $message;
        $this->failed = ! $true;

        return $clone;
    }

    function fail($message) {
        $clone = clone($this);
        $this->message = $message;
        $this->failed = true;
        return $clone;
    }

    function pass($message = null) {
        $clone = clone($this);
        $this->message = $message;
        $this->failed = false;
        return $clone;
    }

    function failed() {
        $this->true;
        return $this->failed;
    }

    function passed() {
        return !$this->failed;
    }

    function __get($name) {
        // empty is not a function has to be treated specially
        if ($name == 'empty') {
            return $this->fail_unless(
                empty($this->value),
                "Expected $this->dump to be empty");
        }

        if (substr($name, 0, 4) == 'not_') {
            $name = substr($name, 4);
            $this->negate;
        }

        if (method_exists($this, $name))
            return $this->$name();

        $candidates = array($name);
        if (substr($name, 0, 3) == 'is_')
            $candidates[] = substr($name, 3);
        else
            $candidates[] = "is_$name";

        foreach ($candidates as $func) {
            if (function_exists($func)) {
                return $this->fail_unless(
                    $func($this->value),
                    "Expect bool(true), got bool(false)"
                );
            }
        }

        throw new \Exception("Check does not have '$name' method");
    }

    function __call($name, $args) {
        if (function_exists($name))
            return $this->equal($name($this->value, $args[0]));

        throw new \Exception("Check does not have '$name' method");
    }

    function spec() {
        return $this->spec = Runner::current()->spec;
    }
}
