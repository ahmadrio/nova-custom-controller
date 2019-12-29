<?php

namespace Opanegro\NovaCustomController\Http\Controllers;

use ReflectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Actions\ActionEvent;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Http\Requests\CreateResourceRequest;

class ResourceStoreController extends Controller
{
    /**
     * Create a new resource.
     *
     * @param CreateResourceRequest $request
     * @return JsonResponse
     * @throws ReflectionException
     * @throws \Throwable
     */
    public function handle(CreateResourceRequest $request)
    {
        $resource = $request->resource();

        $resource::authorizeToCreate($request);

        if (isset($resource::$setCustomRequests) && count($resource::$setCustomRequests) > 0) {
            $request->request->add($resource::$setCustomRequests);
        }

        if (check_override_method($resource, 'customStoreController')) {
            $model = $resource::customStoreController($request, $resource::newModel());

            return $this->defaultResponseStore($model, $resource, $request);
        } else {
            $resource::validateForCreation($request);

            $model = DB::transaction(function () use ($request, $resource) {
                [
                    $model,
                    $callbacks,
                ] = $resource::fill($request, $resource::newModel());

                if (check_override_method($resource, 'beforeCreated')) {
                    $resource::beforeCreated($request, $model);
                }

                if (check_override_method($resource, 'beforeSave')) {
                    $resource::beforeSave($request, $model);
                }

                if (isset($resource::$unsetCustomFields) && count($resource::$unsetCustomFields) > 0) {
                    foreach ($resource::$unsetCustomFields as $field)
                        unset($model->$field);
                }

                if ($request->viaRelationship()) {
                    if (isset($resource::$autoSaveRelations) || $resource::$autoSaveRelations) {
                        $request->findParentModelOrFail()->{$request->viaRelationship}()->save($model);
                    }
                } else {
                    $model->save();
                }

                ActionEvent::forResourceCreate($request->user(), $model)->save();

                if (check_override_method($resource, 'afterCreated')) {
                    $resource::afterCreated($request, $model);
                }

                if (check_override_method($resource, 'afterSave')) {
                    $resource::afterSave($request, $model);
                }

                collect($callbacks)->each->__invoke();

                return $model;
            });

            return $this->defaultResponseStore($model, $resource, $request);
        }
    }

    /**
     * Default response on store controller
     *
     * @param Model $model
     * @param       $resource
     * @param       $request
     * @return JsonResponse
     */
    private function defaultResponseStore(Model $model, $resource, $request)
    {
        $data = [
            'id' => $model->getKey(),
            'resource' => $model->attributesToArray(),
            'redirect' => $resource::redirectAfterCreate($request, $request->newResourceWith($model)),
        ];

        return response_controller_json($data, 201);
    }
}
