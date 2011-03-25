<?php
namespace Phspec;

class Runner {
    static $current;
    public $scenarios = array();

    function __construct($argv) {
        $this->argv = $argv;
    }

    static function main($argv) {
        self::$current= new self($argv);
        return self::$current->run();
    }

    static function current() {
        return static::$current;
    }

    function add($scenario) {
        $this->scenarios[] = $scenario;
    }

    function spec() {
        return $this->spec = $this->argv ? array_pop($this->argv) : 'spec';
    }

    function specs() {
        if (is_file($this->spec))
            return $this->specs = array($this->spec);

        if (is_dir($this->spec))
            return $this->specs = glob("$this->spec/*_spec.php");
    }

    function run() {
        $opts = getopt('hv');

        foreach ($this->specs as $spec)
            include $spec;

        echo "\nTotal scenarios: ".count($this->scenarios).
             ", failed: ".count($this->failed_scenarios)."\n";

        return $this->failed ? 1 : 0;
    }

    function failed_scenarios() {
        $this->failed_scenarios = array();
        foreach ($this->scenarios as $scenario) {
            if ($scenario->failed)
                $this->failed_scenarios[] = $scenario;
        }
        return $this->failed_scenarios;
    }

    function failed() {
        return $this->failed = !!$this->failed_scenarios;
    }

    function __get($name) {
        return method_exists($this, $name) ? $this->$name() : $this->$name;
    }
}
