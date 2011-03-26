<?php

describe('empty array', function() {
    it('should be `empty`', function() {
        check(array())
            ->empty
            ->not_null;
    });
    it('should have count == 0', function() {
        check(count(array()))
            ->is(0)
            ->is_not(10)
            ;
    });
});

describe('array', function() {
    it('should have [] append content at the end', function() {
        $a = array();
        $a[] = 1;
        check($a)->is(array(1));
        $a[] = 2;
        check($a)->is(array(1,2));

    });
    it('should have array_push append content at the end', function() {
        $a = array();
        array_push($a, 1);
        check($a)->is(array(1));
    });
});
