<?php

describe('Check', function() {

    it('should pass is_null if given null', function() {
        $check = new Check(null);
        $check->null;
        check($check->passed);
    });

    it('should fail is_null if given true', function() {
        $check = new Check(true);
        $check->null;
        check($check->failed);
        check($check->message)->is("Expected NULL, got bool(true)");
    });

    it('should fail is_null if given 1', function() {
        $check = new Check(1);
        $check->null;
        check($check->failed);
        check($check->message)->is("Expected NULL, got int(1)");
    });

    it('should respond to both <method> and is_<method>', function() {
        $check = new Check(true);
        $check->true;
        check($check->passed);
        check($check->passed)->true;

        $check = new Check('asdc');
        $check->scalar;
        check($check->passed);
        check($check->passed)->true;
    });

    //it('should pass `is` if given 

});

/*
describe('Runner', function() {

    it('should have a name', function() {
        $runner = new Runner('PHPSpec Runner', null);

        check($runner);//->is_a('Runner');
    });

});
*/
