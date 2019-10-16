<?php

namespace PtDotPlayground\NovaCustomController\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Actions\ActionEvent;
use Laravel\Nova\Http\Requests\CreateResourceRequest;

class ResourceStoreController extends Controller
{
    /**
     * Create a new resource.
     *
     * @param  \Laravel\Nova\Http\Requests\CreateResourceRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(CreateResourceRequest $request)
    {
        $resource = $request->resource();

        $resource::authorizeToCreate($request);

        if (isset($resource::$setCustomRequests) && count($resource::$setCustomRequests) > 0) {
            $request->request->add($resource::$setCustomRequests);
        }

        if (method_exists($resource, 'customStoreController')) {
            return $resource::customStoreController($request, $resource::newModel());
        } else {
            $resource::validateForCreation($request);

            $model = DB::transaction(function () use ($request, $resource) {
                [$model, $callbacks] = $resource::fill(
                    $request, $resource::newModel()
                );

                if (method_exists($resource, 'beforeCreated')) {
                    $resource::beforeCreated($request, $model);
                }

                if (isset($resource::$unsetCustomFields) && count($resource::$unsetCustomFields) > 0) {
                    foreach ($resource::$unsetCustomFields as $field) unset($model->$field);
                }

                if ($request->viaRelationship()) {
                    if (isset($resource::$autoSaveRelations) || $resource::$autoSaveRelations) {
                        $request->findParentModelOrFail()
                            ->{$request->viaRelationship}()
                            ->save($model);
                    }
                } else {
                    $model->save();
                }

                ActionEvent::forResourceCreate($request->user(), $model)->save();

                if (method_exists($resource, 'afterCreated')) {
                    $resource::afterCreated($request, $model);
                }

                collect($callbacks)->each->__invoke();

                return $model;
            });

            return response()->json([
                'id' => $model->getKey(),
                'resource' => $model->attributesToArray(),
                'redirect' => $resource::redirectAfterCreate($request, $request->newResourceWith($model)),
            ], 201);
        }
    }
}
