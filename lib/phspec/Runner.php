<?php
namespace Phspec;

class Runner {
    static function main($argv) {
        $runner = new self($argv);
        $runner->run();
    }

    function __construct($argv) {
        $this->argv = $argv;
    }

    function specs_dir() {
        return $this->specs_dir = $this->argv ? array_pop($this->argv) : 'spec';
    }

    function specs() {
        return $this->specs = glob("$this->specs_dir/*_spec.php");
    }

    function run() {
        $opts = getopt('hv');

        foreach ($this->specs as $spec) {
            include $spec;
        }
    }

    function __get($name) {
        return method_exists($this, $name) ? $this->$name() : $this->$name;
    }
}
