<?php
namespace Phspec;

class Spec {
    static public $current;

    public $checks = array();

    function __construct($name, $func) {
        $this->name = $name;
        $this->func = $func;
    }

    function run() {
        self::$current = $this;
        echo "  it $this->name";

        $func = $this->func;
        try {
            $func();
        } catch (PendingException $e) {
            $this->pending = true;
            $this->message = $e->getMessage();
            echo " PENDING\n";
            return;
        }

        if (! $this->checks) {
            echo "No checks given!\n";
            return;
        }

        if ($this->failed) {
            echo " FAILED\n";
            foreach ($this->failed_checks as $check)
                echo "   $check->message\n";
            echo "\n";
            return;
        }
        echo "\n";
    }

    function add($check) {
        $this->checks[] = $check;
        return $check;
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
