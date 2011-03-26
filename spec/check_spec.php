<?php
namespace Phspec;

describe('Check', function() {

    it('should pass `null` if given null', function() {
        $check = new Check(null);
        $check->null;
        check($check->passed);
    });

    it('should fail `null` if given true', function() {
        $check = new Check(true);
        $check->null;
        check($check->failed);
        check($check->message)->is("Expected NULL, got bool(true)");
    });

    it('should fail `null` if given 1', function() {
        $check = new Check(1);
        $check->null;
        check($check->failed);
        check($check->message)->is("Expected NULL, got int(1)");
    });

    it('should pass `is` only if ===', function() {
        $check = new Check(1);
        $check->is(1);
        check($check->passed);
        $check->is(true);
        check($check->failed);
    });

    it('should pass `match` if regex matches', function() {
        $check = new Check('santa clause');
        $check->match('/santa/');
        check($check->passed);
        $check->match('/snow queen/');
        check($check->failed);
    });

    it('should pass `throws` if exception is thrown', function() {
        $check = new Check(true);
        check(function() {
            throw new \Exception;
        })->throws;
    });

    it('should pass `throws("MyException")` if MyException is thrown', function() {
        class MyException extends \Exception {}
        $check = new Check(true);
        check(function() {
            throw new MyException;
        })->throws('Phspec\MyException');
    });
    
    it('should delegate unknown checks to global functions', function() {
        $check = new Check(10);
        $check->numeric;
        check($check->passed);
    });

    it('should revert check when prepended with `not_`', function() {
        $check = new Check(10);
        $check->not_string;
        check($check->passed);
    });
});

