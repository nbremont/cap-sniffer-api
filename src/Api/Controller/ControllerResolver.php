<?php

namespace Api\Controller;

use Symfony\Component\HttpKernel\Controller\ControllerResolver as BaseControllerResolver;

class ControllerResolver extends BaseControllerResolver
{
    /**
     * {@inheritdoc}
     */
    public function createController($controller)
    {
        if (false === strpos($controller, '::')) {
            throw new \InvalidArgumentException(sprintf('Unable to find controller "%s".', $controller));
        }

        list($class, $method, $arguments) = explode('::', $controller, 3);

        if (!class_exists($class)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" does not exist.', $class));
        }

        return array($this->instantiateController($class, $arguments), $method);
    }

    /**
     * {@inheritdoc}
     */
    public function instantiateController($class, $arguments)
    {
        return call_user_func_array([new ReflectionClass($class), 'newInstance'], $arguments);
    }
}