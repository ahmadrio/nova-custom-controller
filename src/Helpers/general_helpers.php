<?php

if (!function_exists('check_override_method')) {
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
}

if (function_exists('response_controller_json')) {
    /**
     * Response controller
     *
     * @param array $data
     * @param int   $status_code
     * @return \Illuminate\Http\JsonResponse
     */
    function response_controller_json(array $data = [], $status_code = 201)
    {
        return response()->json($data, $status_code);
    }
}
