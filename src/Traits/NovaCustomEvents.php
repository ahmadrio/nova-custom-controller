<?php

namespace PtDotPlayground\NovaCustomController\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait NovaCustomEvents
{
    /**
     * Before updated in controller
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public static function beforeUpdated(Request $request, Model $model)
    {}

    /**
     * After updated in controller
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public static function afterUpdated(Request $request, Model $model)
    {}

    /**
     * Before created in controller
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public static function beforeCreated(Request $request, Model $model)
    {}

    /**
     * After created in controller
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public static function afterCreated(Request $request, Model $model)
    {}
}
