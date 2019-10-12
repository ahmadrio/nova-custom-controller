<?php

namespace DotNova\NovaCustomControllers\Traits;

use Illuminate\Http\Request;

trait NovaCustomControllers
{
    /**
     * Before updated in controller
     *
     * @param Request $request
     */
    public static function beforeUpdated(Request $request)
    {}

    /**
     * After updated in controller
     *
     * @param Request $request
     */
    public static function afterUpdated(Request $request)
    {}

    /**
     * Before created in controller
     *
     * @param Request $request
     */
    public static function beforeCreated(Request $request)
    {}

    /**
     * After created in controller
     *
     * @param Request $request
     */
    public static function afterCreated(Request $request)
    {}
}
