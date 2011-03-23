<?php

class Scenario {
    static $current;

    public $specs = array();
    public $before = array();
    public $before_each = array();
    public $after = array();
    public $after_each = array();

    static function current() {
        if (! isset(static::$current))
            static::$current = new self('Default Runner', null);
        return static::$current;
    }

    function __construct($name, $func = null) {
        $this->name = $name;
        static::$current = $this;
    }

    function run() {
        echo "Describe $this->name:\n";

        if (! $this->specs) {
            echo " No specs given!\n";
            return;
        }

        foreach ($this->before as $block)
            $block->run;

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

    function add($block) {
        if ($block instanceof Spec)
            return $this->specs[] = Spec::$current = $block;

        if ($block instanceof Block) {
            if ($block->is_before)
                $this->before[] = $block;
            if ($block->is_before_each)
                $this->before_each[] = $block;
            if ($block->is_after)
                $this->after[] = $block;
            if ($block->is_after_each)
                $this->after_each[] = $block;
        }
    }

    function spec() {
        return $this->spec = Spec::current();
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
