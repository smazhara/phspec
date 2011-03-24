<?php
namespace Porcupine;

function scenario() {
    return Scenario::current();
}

function spec() {
    return Spec::current();
}

function describe($name, $func) {
    $scenario = new Scenario($name, $func);
    $func();
    $scenario->run();
}

function it($name, $func) {
    return scenario()->add(new Spec($name, $func));
}

function check($value) {
    return spec()->add(new Check($value));
}

function before($func) {
    return scenario()->add(Block::before($func));
}

function before_each($func) {
    return scenario()->add(Block::before_each($func));
}

function after($func) {
    return scenario()->add(Block::after($func));
}

function after_each($func) {
    return scenario()->add(Block::after_each($func));
}

function at() {
    return scenario()->at;
}
