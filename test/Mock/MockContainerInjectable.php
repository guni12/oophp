<?php

namespace Guni\Movie;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A mock class implementing interface and trait to be injectable.
 */
class MockContainerInjectable implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function getDI() : object
    {
        return $this->di;
    }
}
