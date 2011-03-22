<?php

describe('Check', function() {

    it('should pass is_null if given null', function() {
        $check = new Check(null);
        $check->is_null;
        check($check->passed);
    });

    it('should fail is_null if given true', function() {
        $check = new Check(true);
        $check->is_null;
        check($check->failed);
        check($check->message)->is("Expected NULL, got bool(true)");
    });

    it('should fail is_null if given 1', function() {
        $check = new Check(1);
        $check->is_null;
        check($check->failed);
        check($check->message)->is("Expected NULL, got int(1)");
    });

    it('should respond to both <method> and is_<method>', function() {
        $check = new Check(true);
        $check->is_true;
        check($check->passed);
        check($check->passed)->true;
        check($check->passed)->is_true;

        $check = new Check('asdc');
        $check->scalar;
        check($check->passed);
        check($check->passed)->true;
        check($check->passed)->is_true;
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
