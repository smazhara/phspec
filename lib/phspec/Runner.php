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

        foreach ($this->specs as $spec) {
            include $spec;
        }
    }

    function __get($name) {
        return method_exists($this, $name) ? $this->$name() : $this->$name;
    }
}
