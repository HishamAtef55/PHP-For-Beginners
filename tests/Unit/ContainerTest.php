<?php

use Core\Container;

it('can resolve container', function () {
    // arrange
    $container = new Container();
    $container->bind('foo', fn () => 'bar');
    // act
    $result = $container->resolve('foo');
    // assert / except
    expect($result)->toEqual('bar');
});
