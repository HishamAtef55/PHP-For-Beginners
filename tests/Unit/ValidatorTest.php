<?php

use Core\Validator;

it('validate a string', function () {
    expect(Validator::string('bfgbfg'))->toBeTrue();
    expect(Validator::string(''))->toBeFalse();
});


it('validate a string with aminmum 20 character', function () {

    expect(Validator::string('bvdfbd', 20))->toBeFalse();
});

it('validate email', function () {
    expect(Validator::email('hisham@gmail.com'))->toBeTrue();
    expect(Validator::email('hisham@gmail'))->toBeFalse();
});
