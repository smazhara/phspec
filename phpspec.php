<?php

function describe($name, $function) {
    $runner = new Runner($name, $function);
    $runner->run();
}

function it($name, $function) {
    $spec = new Spec($name, $function);
    $spec->run();
}

function expect($value) {
    return new Expectation($value);
}

class Spec {
    public $expectations = array();

    function __construct($name, $function) {
        $this->name = $name;
        $this->function = $function;
        Runner::$current->spec = $this;
        Runner::$current->specs[] = $this;
    }

    function run() {
        $function = $this->function;
        $function();
    }

    function add(Expectation $expectation) {
        $this->expectations[] = $expectation;
    }

    function failed() {
        foreach ($this->expectations as $expectation) {
            if ($expectation->failed)
                return $this->failed = true;
        }
        return $this->failed = false;
    }

    function __get($name) {
        return method_exists($this, $name) ? $this->$name() : $this->$name;
    }
}

class Expectation {
    function __construct($value) {
        $this->value = $value;
    }

    function equal($value) {
        return $this->fail_unless(
            $this->value == $value,
            "Expected '$value', got '$this->value'"
        );
    }

    //function 

    function fail_unless($true, $message) {
        $clone = clone($this);
        $this->message = $message;
        $this->failed = ! $true;
        $this->spec->add($this);

        return $clone;
    }

    function __get($name) {
        return method_exists($this, $name) ? $this->$name() : $this->$name;
    }

    function spec() {
        return $this->spec = Runner::$current->spec;
    }
}

class Runner {
    static $current;

    public $spec;
    public $specs = array();

    function __construct($name, $spec) {
        $this->name = $name;
        $this->spec = $spec;
    }

    function run() {
        $spec = $this->spec;
        static::$current = $this;
        $spec();

        echo "Describe $this->name:\n";
        foreach ($this->specs as $spec)
        {
            echo " it $spec->name - ".($spec->failed ? 'FAILED' : 'OK')."\n"; 
        }
    }

    function __get($name) {
        return method_exists($this, $name) ? $this->$name() : $this->$name;
    }
}

// tests

class User {
    function __construct($name) {
        $this->name = $name;
    }
}

describe('User', function() {

    it('should have a name', function() {
        $user = new User('stan');
        expect($user->name)->equal('stan');
    });

});
