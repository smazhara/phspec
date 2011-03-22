<?php

class Runner {
    static $current;

    static function current() {
        if (! isset(static::$current))
            static::$current = new self('Default Runner', null);
        return static::$current;
    }

    function __construct($name, $spec = null) {
        $this->name = $name;
        if ($spec)
            $this->spec = $spec;
        static::$current = $this;
    }

    function run() {
        echo "Describe $this->name:\n";

        if (! $this->specs) {
            echo " No specs given!\n";
            return;
        }

        foreach ($this->specs as $spec)
        {
            echo " it $spec->name - ";
            if (! $spec->checks) {
                echo "No checks given!\n";

            } elseif (! isset($spec->failed)) {
                if ($spec->failed) {
                    echo "FAILED\n";
                    foreach ($spec->failed_checks as $check)
                        echo "   $check->message\n";
                } else {
                    echo "OK";
                }
            }
            echo "\n";
        }

        echo "Total specs: ".count($this->specs)." ".
             "failed: ".count($this->failed_specs)."\n";
    }

    function add(Spec $spec) {
        $this->specs[] = $this->spec = $spec;
    }

    function spec() {
        return $this->spec = new Spec('Default Spec', null);
    }

    function specs() {
        return $this->specs = array($this->spec);
    }

    function failed_specs() {
        $this->failed_specs = array();
        foreach ($this->specs as $spec) {
            if ($spec->failed)
                $this->failed_specs[] = $spec;
        }
        return $this->failed_specs;
    }

    function __get($name) {
        return method_exists($this, $name) ? $this->$name() : $this->$name;
    }
}
