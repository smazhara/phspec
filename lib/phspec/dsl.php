<?php

function scenario() {
    return Phspec\Scenario::current();
}

function spec() {
    return Phspec\Spec::current();
}

function describe($name, $func) {
    $scenario = new Phspec\Scenario($name, $func);
    $func();
    $scenario->run();
}

function it($name, $func) {
    return scenario()->add(new Phspec\Spec($name, $func));
}

function check($value) {
    return spec()->add(new Phspec\Check($value));
}

function before($func) {
    return scenario()->add(Phspec\Block::before($func));
}

function before_each($func) {
    return scenario()->add(Phspec\Block::before_each($func));
}

function after($func) {
    return scenario()->add(Phspec\Block::after($func));
}

function after_each($func) {
    return scenario()->add(Phspec\Block::after_each($func));
}

function at() {
    return scenario()->at;
}

function pending($message = 'No reason given') {
    throw new Phspec\PendingException($message);
}

function stub($obj) {
    return new Phspec\Stubber($obj);
}
