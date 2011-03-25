<?php
namespace Phspec;

describe('Runner', function() {
    function run_spec($spec) {
        $spec_file = tempnam(sys_get_temp_dir(), 'spec');
        file_put_contents($spec_file, "
            <?php
            describe('Runner', function() {
                $spec
            });
        ");
        $phspec = "{$GLOBALS['argv'][0]} $spec_file";
        exec($phspec, $output, $retval);
        $res = new \stdClass;
        $res->output = $output;
        $res->retval = $retval;
        unlink($spec_file);

        return $res;
    }

    it('should return 0 exit code if all specs are passed', function() {
        $res = run_spec('
            it("should pass", function() {
                check(true);
            });
        ');
        check($res->retval)->is(0);
    });

    it('should return 1 exit code if at least one spec failed', function() {
        $res = run_spec('
            it("should pass", function() {
                check(true);
            });
            it("should fail", function() {
                check(fail);
            });
        ');
        check($res->retval)->is(1);
    });
});
