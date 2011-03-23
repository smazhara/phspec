<?php

class Spec {
    static public $current;

    public $checks = array();

    function __construct($name, $func) {
        self::$current = $this;
        $this->name = $name;
        if ($func)
            $func();
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

    static function current() {
        if (! isset(static::$current))
            static::$current = new self('checks something', null);
        return static::$current;
    }

    function __get($name) {
        return method_exists($this, $name) ? $this->$name() : $this->$name;
    }
}
