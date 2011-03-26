<?php

class User {
    function name() {
        return 'real name';
    }
}

describe('Stub', function() {
    it('should stub an object', function() {
        $user = new User;
        check($user->name())->is('real name');

        $stub = stub($user)->name->return('stubbed name');
        check($stub->name)->is('stubbed name');
    });
});
