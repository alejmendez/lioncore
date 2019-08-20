<?php

namespace Modules\Core\Http\Controllers;

use DataTables;

// Request
use Illuminate\Http\Request;

use Modules\Core\Traits\ApiResponse;

class CrudController extends BaseController
{
    use ApiResponse;

    protected $model = '';
    protected $permission = '';
    protected $view = '';

    protected $validationRules = [];

    /**
     * Get instance
     *
     * @return type
     */
    protected function getInstance()
    {
        return $this->model::query();
    }

    /**
     * Get all rows
     *
     * @return type
     */
    protected function getAll()
    {
        $instane = $this->getInstance();
        if (!empty($this->selectAll)) {
            $instane->select($this->selectAll);
        }

        return $instane;
    }

    /**
     * Manage index request
     * @return type
     */
    public function index()
    {
        return $this->view($this->view);
    }

    /**
     * Manage datatable request
     * @return type
     */
    public function datatable()
    {
        $this->middleware('permission:' . $this->permission);

        $model = $this->getInstance();
        return $this->getInstanceDatatable($model);
    }

    /**
     * return instance of datatable
     * @return type
     */
    public function getInstanceDatatable($model)
    {
        return DataTables::of($model)
            ->addColumn('action', function ($instance) {
                return '<div class="btn-group" style="width: 78px;">' .
                    '<button type="button" class="btn btn-info" data-id="' . $instance->id . '"><i class="fa fa-edit"></i></button>' .
                    '<button type="button" class="btn btn-danger" data-id="' . $instance->id . '"><i class="fa fa-trash"></i></button>' .
                '</div>';
            })
            ->make(true);
    }

    /**
     * Return one row
     * @param integer $id
     * @return type
     */
    public function getOne($id)
    {
        $instance = $this->getInstance();
        $instance = empty($this->selectOne) ? $instance : $instance->select($this->selectOne);
        $result = $instance->findOrFail($id);

        return $result;
    }

    /**
     * Manage show profile request
     * @param integer $id
     * @return type
     */
    public function show($id)
    {
        $this->middleware('permission:' . $this->permission . ' show');

        $instance = $this->getOne($id);

        return $this->showResponse($instance);
    }

    public function getFormData()
    {
        return request()->all();
    }

    /**
     * Manage store request
     * @param Request $request
     * @return type
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $this->middleware('permission:' . $this->permission . ' store');

        try {
            $data = $this->getFormData();
            $validator = validator($data, $this->getValidations());
            if ($validator->fails()) {
                throw new \Exception(__('Validation error'));
            }
            $instance = $this->model::create($data);
            $this->_store($data, $instance);
            return $this->createdResponse($instance);
        } catch (\Exception $ex) {
            return $this->clientErrorResponse([
                'form_validations' => $validator->errors(),
                'exception' => $ex->getMessage()
            ]);
        }
    }

    protected function _store($data, $instance)
    {
        return true;
    }

    /**
     * Manage update request
     * @param type $id
     * @param Request $request
     * @return type
     * @throws \Exception
     */
    public function update($id)
    {
        $this->middleware('permission:' . $this->permission . ' update');

        $data = $this->getFormData();
        $instance = $this->model::findOrFail($id);

        $validator = validator($data, $this->getValidations($instance));
        try {
            if ($validator->fails()) {
                throw new \Exception(__('Validation error'));
            }
            $instance->fill($data);
            $instance->save();

            $this->_update($data, $instance);

            return $this->showResponse($instance);
        } catch (\Exception $ex) {
            return $this->clientErrorResponse([
                'form_validations' => $validator->errors(),
                'exception' => $ex->getMessage()
            ]);
        }
    }

    protected function _update($data, $instance)
    {
        return true;
    }

    /**
     * Manage delete request
     * @param type $id
     * @return type
     */
    public function destroy($id)
    {
        $this->middleware('permission:' . $this->permission . ' destroy');

        $model = $this->getInstance();
        $instance = $model->findOrFail($id);
        $instance->delete();

        $this->_destroy($instance);

        return $this->deletedResponse();
    }

    protected function _destroy($instance)
    {
        return true;
    }

    protected function getValidations($instance = null)
    {
        $rules = $this->validationRules;
        if (!$instance) {
            return $rules;
        }

        foreach ($rules as $field => $rule) {
            if (is_string($rule)) {
                $rules[$field] = $rule = explode('|', $rule);
            }
            foreach ($rule as $k => $v) {
                if (strpos($v, "unique:") !== false) {
                    $rules[$field][$k] = $v . "," . $instance->id . "," . $instance->getKeyName();
                }
            }
        }

        return $rules;
    }
}
