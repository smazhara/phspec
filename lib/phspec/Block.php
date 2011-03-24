<?php
namespace Phspec;

class Block {

    function __construct($type, $func) {
        $this->type = $type;
        $this->func = $func;
    }

    static function before($func) {
        return new self('before', $func);
    }

    static function before_each($func) {
        return new self('before each', $func);
    }

    static function after($func) {
        return new self('after', $func);
    }

    static function after_each($func) {
        return new self('after each', $func);
    }

    function run() {
        $func = $this->func;
        $func();
    }

    function runner() {
        return Runner::current();
    }

    function is_before() {
        return $this->type == 'before';
    }

    function is_before_each() {
        return $this->type == 'before each';
    }

    function is_after() {
        return $this->type == 'after';
    }

    function is_after_each() {
        return $this->type == 'after each';
    }

    function __get($name) {
        return method_exists($this, $name) ? $this->$name() : $this->$name;
    }
}
