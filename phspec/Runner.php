<?php

class Runner {
    static $current;

    public $spec;
    public $specs = array();

    function __construct($name, $spec) {
        $this->name = $name;
        $this->spec = $spec;
        static::$current = $this;
    }

    function run() {
        echo "Describe $this->name:\n";
        foreach ($this->specs as $spec)
        {
            echo " it $spec->name - ";
            if (! $spec->expectations) {
                echo "warning: no expectations";
            } elseif (! isset($spec->failed)) {
                if ($spec->failed) {
                    echo "FAILED\n";
                    foreach ($spec->failed_expectations as $expectation)
                        echo "   $expectation->message\n";
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
