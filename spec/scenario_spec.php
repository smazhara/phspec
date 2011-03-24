<?php
namespace Phspec;

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

// has to run outside of describe, otherwise we won't be able to catch 'after' 
// call
$steps = Scenario::current()->at->steps;
check($steps)->equal(array(
    'before',
    'before_each', 'one', 'after_each',
    'before_each', 'two', 'after_each',
    'after'
));

