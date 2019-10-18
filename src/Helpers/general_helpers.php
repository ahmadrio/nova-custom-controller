<?php

/**
 * Check all method in classes if the method is override on parent
 *
 * @param $class
 * @param $method
 * @return bool
 * @throws ReflectionException
 */
function check_override_method($class, $method)
{
    $reflectionMethod = new \ReflectionMethod($class, $method);
    if ($reflectionMethod->getDeclaringClass()->getName() === $class) {
        return true;
    }
    return false;
}
