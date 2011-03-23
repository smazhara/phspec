<?php

function describe($name, $function) {
    $scenario = new Scenario($name, $function);
    $function();
    $scenario->run();
}

function it($name, $function) {
    Scenario::current()->add(new Spec($name, $function));
}

function check($value) {
    $check = new Check($value);
    Spec::current()->add($check);
    return $check;
}

function before($func) {
    Scenario::current()->add(Block::before($func));
}

function before_each($func) {
    Scenario::current()->add(Block::before_each($func));
}

function after($func) {
    Scenario::current()->add(Block::after($func));
}

function after_each($func) {
    Scenario::current()->add(Block::after_each($func));
}
