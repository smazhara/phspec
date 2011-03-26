<?php

class User {
    function name() {
        return 'real name';
    }
    function age() {
        return 30;
    }
}

describe('Stub', function() {
    it('should stub an object', function() {
        $user = new User;
        check($user->name())->is('real name');
        check($user->age())->is(30);

        $stub = stub($user)->name()->return('stubbed name');
        check($stub->name)->is('stubbed name');
        check($stub->age())->is(30);
    });
});
