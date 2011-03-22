<?php

function describe($name, $function) {
    $runner = new Runner($name, $function);
    $function();
    $runner->run();
}

function it($name, $function) {
    Runner::current()->add(new Spec($name, $function));
}

function check($value) {
    $expectation = new Check($value);
    Runner::current()->spec->add($expectation);
    return $expectation;
}
