<?php

function describe($name, $function) {
    $runner = new Runner($name, $function);
    $function();
    $runner->run();
}

function it($name, $function) {
    Runner::$current->add(new Spec($name, $function));
}

function expect($value) {
    $expectation = new Expectation($value);
    Runner::$current->spec->add($expectation);
    return $expectation;
}
