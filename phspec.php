<?php

require_once __DIR__.'/phspec/Spec.php';
require_once __DIR__.'/phspec/Expectation.php';
require_once __DIR__.'/phspec/Runner.php';
require_once __DIR__.'/phspec/dsl.php';

class User {
    function __construct($name) {
        $this->name = $name;
    }
}

describe('User', function() {

    it('should have a name', function() {
        $user = new User('stan');
        $user->white = null;
        expect($user->name)
            ->equal('stan')
            ->is('stan')
        ;
        expect($user->white)->is_null;
    });

});
