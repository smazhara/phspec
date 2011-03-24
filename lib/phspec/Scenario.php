<?php
namespace Phspec;

class Scenario {
    static $current;

    public $specs = array();
    public $before = array();
    public $before_each = array();
    public $after = array();
    public $after_each = array();

    static function current() {
        if (! isset(static::$current))
            static::$current = new self('Default Scenario', null);
        return static::$current;
    }

    function __construct($name, $func = null) {
        $this->at = new \stdClass;
        $this->name = $name;
        static::$current = $this;
    }

    function run() {
        echo "$this->name:\n";

        if (! $this->specs) {
            echo " No specs given!\n";
            return;
        }

        foreach ($this->before as $block)
            $block->run();

        foreach ($this->specs as $spec)
        {
            foreach ($this->before_each as $block)
                $block->run();

            $spec->run();

            foreach ($this->after_each as $block)
                $block->run();
        }

        foreach ($this->after as $block)
            $block->run();

        echo "Total specs: ".count($this->specs)." ".
             "failed: ".count($this->failed_specs)."\n";
    }

    function add($block) {
        if ($block instanceof Spec)
            $this->specs[] = Spec::$current = $block;

        elseif ($block instanceof Block) {
            if ($block->is_before)
                $this->before[] = $block;
            if ($block->is_before_each)
                $this->before_each[] = $block;
            if ($block->is_after)
                $this->after[] = $block;
            if ($block->is_after_each)
                $this->after_each[] = $block;
        }

        return $block;
    }

    function spec() {
        return $this->spec = Spec::current();
    }

    function failed_specs() {
        return $this->failed_specs = array_filter($this->specs,
            function($spec) {
                return $spec->failed;
            }
        );
    }

    function scen() {
        return $this->scen;
    }

    function __get($name) {
        return method_exists($this, $name) ? $this->$name() : $this->$name;
    }
}
