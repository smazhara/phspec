<?php
require_once 'Bowling.php';

describe('Bowling::score', function() {
    it('returns 0 for all gutter game', function() {
        $bowling = new Bowling;
        foreach(range(0,20) as $i)
            $bowling->hit(0);
        check($bowling->score)->is(0);
    });

    it('pending', function() {
        pending('not done yet');
        die('here');
    });
});
