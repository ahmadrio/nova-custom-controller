<?php

namespace PtDotPlayground\NovaCustomController\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait NovaCustomEvents
{
    /**
     * Remove custom fields in model before submit button
     *
     * @var array
     */
    public static $unsetCustomFields = [];

    /**
     * Add custom requests in model before submit button
     *
     * @var array
     */
    public static $setCustomRequests = [];

    /**
     * Set auto save relations from eloquent
     *
     * @var bool
     */
    public static $autoSaveRelations = true;

    /**
     * Before updated in controller
     *
     * @param Request $request
     * @param Model $model
     */
    public static function beforeUpdated(Request $request, Model $model)
    {}

    /**
     * After updated in controller
     *
     * @param Request $request
     * @param Model $model
     */
    public static function afterUpdated(Request $request, Model $model)
    {}

    /**
     * Before created in controller
     *
     * @param Request $request
     * @param Model $model
     */
    public static function beforeCreated(Request $request, Model $model)
    {}

    /**
     * After created in controller
     *
     * @param Request $request
     * @param Model $model
     */
    public static function afterCreated(Request $request, Model $model)
    {}

    /**
     * Custom store controller
     *
     * @param Request $request
     * @param Model $model
     */
    public static function customStoreController(Request $request, Model $model)
    {}

    /**
     * Custom update controller
     *
     * @param Request $request
     * @param Model $model
     */
    public static function customUpdateController(Request $request, Model $model)
    {}
}
