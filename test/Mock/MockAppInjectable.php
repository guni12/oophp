<?php

namespace Guni\Movie;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

/**
 * A mock class implementing interface and trait to be injectable.
 */
class MockAppInjectable implements AppInjectableInterface
{
    use AppInjectableTrait;

    public function getApp()
    {
        return $this->app;
    }
}
