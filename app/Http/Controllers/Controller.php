<?php

namespace App\Http\Controllers;

use App\Helpers\Utils;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $model = null;
    protected $modelName = null;
    protected $validator = null;

    public function __construct($model, $validator = null, $options = [])
    {
        $this->model = $model;
        $this->validator = $validator;
        $this->modelName = strtolower(class_basename($model));

        $fileOptions = [
            'modelName' => $this->modelName,
            'files' => !empty($options['files']) ? $options['files'] : []
        ];
        $this->middleware('fileupload:' . serialize($fileOptions))->only('post');
    }

    public function get(Request $request)
    {
        $user = Auth::user();

        /**
         * =================================
         * 1. Get Available Fields
         * =================================
         */
        $avFields = $this->model::getAvailableFields('web', $user->role, 'r');

        /**
         * =================================
         * 2. Request Validation
         * =================================
         */
        // Relationships
        $otherModels = [];
        $relationships = $request->query('with');
        if (is_array($relationships)) {
            foreach ($relationships as $relationship) {
                if (!method_exists($this->model, $relationship)) {
                    return Utils::responseJsonError(trans('invalid_request'));
                }
                $otherModel = (new $this->model)->{$relationship}()->getRelated();
                array_push(
                    $otherModels,
                    $relationship . ':' . implode(',', $otherModel::getAvailableFields('web', $user->role, 'r'))
                );
            }
        }

        // Search Option
        $searchKey = $request->query('searchKey');
        $searchValue = $request->query('searchValue');
        $searchKeyType = gettype($searchKey);
        if ($searchKeyType === 'string' && !in_array($searchKey, $avFields))
            $searchKey = null;
        else if ($searchKeyType === 'array') {
            for ($i = 0; $i < count($searchKey); $i++) {
                if (!in_array($searchKey[$i], $avFields)) {
                    array_splice($searchKey, $i, 1);
                    $i--;
                }
            }
            if (count($searchKey) === 0) $searchKey = null;
        } else $searchValue = null;

        // Sort Option
        $sortKey = $request->query('sortKey');
        $sortArrow = $request->query('sortArrow');
        if (gettype($sortKey) !== 'string' || in_array($sortKey, $avFields)) $sortKey = null;
        if ($sortArrow !== 'desc' && $sortArrow !== 'asc') $sortArrow = null;

        // Pagination Option
        $pageSize = $request->query('pageSize');
        $pageIndex = $request->query('pageIndex');
        if (gettype($pageSize) !== 'integer' || $pageSize < 5 || $pageSize > 100) $pageSize = null;
        if (gettype($pageIndex) !== 'integer') $pageIndex = null;

        $conditions = $this->beforeGet();

        /**
         * =================================
         * 3. Get
         * =================================
         */
        $query = $this->model::select($avFields)
            ->with($otherModels)
            ->where(function ($query) use ($conditions) {
                if ($conditions) {
                    Utils::setConditions2Query($query, $conditions);
                }
            })
            ->where(function ($query) use ($searchValue, $searchKey) {
                if ($searchKey && $searchValue) {
                    Utils::setConditions2Query($query, [[$searchKey, 'like', '%' . $searchValue . '%']]);
                }
            });
        if ($sortKey && $sortArrow) {
            $query->orderBy($sortKey, $sortArrow);
        }
        if ($pageSize && $pageIndex) {
            $query->skip($pageSize * $pageIndex)->take($pageSize);
        }
        $data = $query->get();

        $error = $this->afterGet($data);
        if ($error) return Utils::responseJsonError($error);

        return Utils::responseJsonData($data);
    }

    public function getById(Request $request, $id)
    {
        $user = Auth::user();

        /**
         * =================================
         * 1. Request Validation
         * =================================
         */
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer',
        ], [
            'id.required' => trans('empty_' . $this->modelName . '_id'),
            'id.integer' => trans('invalid_' . $this->modelName . '_id'),
        ]);
        if ($validator->fails()) {
            return Utils::responseJsonError($validator->errors()->first());
        }

        // Relationships
        $otherModels = [];
        $relationships = $request->query('with');
        if (is_array($relationships)) {
            foreach ($relationships as $relationship) {
                if (!method_exists($this->model, $relationship)) {
                    return Utils::responseJsonError(trans('invalid_request'));
                }
                $otherModel = (new $this->model)->{$relationship}()->getRelated();
                array_push(
                    $otherModels,
                    $relationship . ':' . implode(',', $otherModel::getAvailableFields('web', $user->role, 'r'))
                );
            }
        }

        /**
         * =================================
         * 2. Get Available Fields
         * =================================
         */
        $avFields = $this->model::getAvailableFields('web', $user->role, 'r');

        $error = $this->beforeGetById();
        if ($error) return Utils::responseJsonError($error);

        /**
         * =================================
         * 3. Get User
         * =================================
         */
        $data = $this->model::with($otherModels)->select($avFields)->where(['id' => $id])->first();
        if (!$data) return Utils::responseJsonError(trans('invalid_' . $this->modelName . '_id'));

        $error = $this->afterGetById($data);
        if ($error) return Utils::responseJsonError($error);

        return Utils::responseJsonData($data);
    }

    public function getOthersById(Request $request, $id, $model, $foreignKey)
    {
        $user = Auth::user();

        /**
         * =================================
         * 1. Request Validation
         * =================================
         */
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer',
        ], [
            'id.required' => trans('empty_' . $this->modelName . '_id'),
            'id.integer' => trans('invalid_' . $this->modelName . '_id'),
        ]);
        if ($validator->fails()) {
            return Utils::responseJsonError($validator->errors()->first());
        }
        $row = $this->model::find($id);
        if (empty($row)) {
            return Utils::responseJsonError(trans('invalid_' . $this->modelName . '_id'));
        }

        /**
         * =================================
         * 2. Get Available Fields
         * =================================
         */
        $avFields = $model::getAvailableFields('web', $user->role, 'r');

        $conditions = $this->beforeGetOthersById($model);

        /**
         * =================================
         * 3. Get
         * =================================
         */
        $data = $model::select($avFields)
            ->where([$foreignKey => $id])
            ->where(function ($query) use ($conditions) {
                Utils::setConditions2Query($query, $conditions);
            })
            ->get();

        $error = $this->afterGetOthersById($model, $data);
        if ($error) return Utils::responseJsonError($error);

        return Utils::responseJsonData($data);
    }


    public function post(Request $request)
    {
        $user = Auth::user();
        $body = $request->all();

        if (empty($body['id'])) {
            // Create
            /**
             * =================================
             * 1. Get Available Fields
             * =================================
             */
            $avFields = $this->model::getAvailableFields('web', $user->role, 'c');

            /**
             * =================================
             * 2. Request Validation
             * =================================
             */
            if (isset($this->validator)) {
                $validationError = $this->validator::validate($body, $avFields, 'c');
                if (!empty($validationError)) {
                    return Utils::responseJsonError($validationError);
                }
            }

            $data = Utils::onlyKeysInArray($body, $avFields);

            $error = $this->beforeCreate($data);
            if ($error) return Utils::responseJsonError($error);

            /**
             * =================================
             * 3. Create
             * =================================
             */
            $created = $this->model::create($data);

            if ($created) {
                return Utils::responseJsonData();
            } else {
                return Utils::responseJsonError(trans('internal_error'));
            }
        } else {
            // Update
            /**
             * =================================
             * 1. Get Available Fields
             * =================================
             */
            $avFields = $this->model::getAvailableFields('web', $user->role, 'u');

            /**
             * =================================
             * 2. Request Validation
             * =================================
             */
            if (isset($this->validator)) {
                $validationError = $this->validator::validate($body, $avFields, 'u');
                if (!empty($validationError)) {
                    return Utils::responseJsonError($validationError);
                }
            }

            $id = $body['id'];

            $data = Utils::onlyKeysInArray($body, $avFields);

            $error = $this->beforeUpdate($data);
            if ($error) return Utils::responseJsonError($error);

            /**
             * =================================
             * 3. Update
             * =================================
             */
            $updated = $this->model::find($id)->update($data);

            if ($updated) {
                return Utils::responseJsonData();
            } else {
                return Utils::responseJsonError(trans('internal_error'));
            }
        }
    }

    public function delete(Request $request)
    {
        $user = Auth::user();

        /**
         * =================================
         * 1. Request Validation
         * =================================
         */
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ], [
            'id.required' => trans('empty_' . $this->modelName . '_id'),
            'id.integer' => trans('invalid_' . $this->modelName . '_id'),
        ]);
        if ($validator->fails()) {
            return Utils::responseJsonError($validator->errors()->first());
        }

        $id = $request->all()['id'];

        // Check if the identifier is valid
        $data = $this->model::find($id);
        if (!$data) return Utils::responseJsonError('invalid_' . $this->modelName . '_id');

        $error = $this->beforeDelete($id);
        if ($error) return Utils::responseJsonError($error);

        /**
         * =================================
         * 2. Delete row with id
         * =================================
         */
        $deleted = $this->model::destroy($id);
        if ($deleted) {
            return Utils::responseJsonData();
        } else {
            return Utils::responseJsonError(trans('invalid_' . $this->modelName . '_id'));
        }
    }

    protected function beforeGet(): array { return []; }

    protected function afterGet(&$data){ return null; }

    protected function beforeGetById() { return null; }

    protected function afterGetById(&$data){ return null; }

    protected function beforeCreate(&$data){ return null; }

    protected function beforeUpdate(&$data) { return null; }

    protected function beforeDelete($id) { return null; }

    protected function beforeGetOthersById($model): array { return []; }

    protected function afterGetOthersById($model, &$data) { return null; }
}
