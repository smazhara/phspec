<?php
namespace Porcupine;

describe('Scenario', function() {
    before(function() {
        at()->steps = array('before');
    });

    before_each(function() {
        at()->steps[] = 'before each';
    });

    after(function() {
        at()->steps[] = 'after';
    });

    after_each(function() {
        at()->steps[] = 'after each';
    });

    it('should run', function() {
        at()->steps[] = 'one';
        check(true); // dummy check to prevent warning
    });

    it('should run `after` last', function() {
        at()->steps[] = 'two';
        check(true); // dummy check to prevent warning
    });
});

$steps = Scenario::current()->at->steps;
check($steps)->equal(array(
    'before',
    'before_each', 'one', 'after_each',
    'before_each', 'two', 'after_each',
    'after'
));
exit;
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
            throw new Exception;
        })->throws;
    });
    
    it('should delegate unknown checks to global functions', function() {
        $check = new Check(10);
        $check->numeric;
        check($check->passed);
    });
});

