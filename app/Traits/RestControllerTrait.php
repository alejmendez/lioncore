<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

/**
 * Trait de Controladores
 *
 * @category Trait
 * @package  App\Traits
 * @author   Alejandro Méndez <alejmendez.87@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html MIT
 * @link     http://url.com
 */
trait RestControllerTrait
{
    
    /**
     * Get all rows
     *
     * @return type
     */
    protected function getAll()
    {
        $m = self::MODEL;
        return $m::query();
    }

    /**
     * Manage index request
     * @param Request $request
     * @return type
     */
    public function index(Request $request) 
    {
        $this->middleware('permission:' . self::PERMISSION);

        $m = $this->getAll();
        if ($request->has('sortBy')) {
            $descending = $request->input('descending', false) ? 'asc' : 'desc';
            $m->orderBy($request->sortBy, $descending);
        }
        
        if ($request->has('fields')) {
            $fields = $request->fields;
            $fields = explode(',', $fields);
            $fields = array_map('trim', $fields);

            $m->select($fields);
        }
        
        $rowsPerPage = $request->input('rowsPerPage', 10);
        $page = $request->input('page', 1);

        //Paginate settings
        $limit = $request->get('limit', $rowsPerPage);
        $page = $request->get('page', $page);
        Paginator::currentPageResolver(function() use ($page) {
            return $page;
        });

        $instance = $m->paginate($limit);
        return $this->listResponse($instance);
    }

    /**
     * Return one row
     * @param integer $id
     * @return type
     */
    public function getOne($id)
    {
        $m = self::MODEL;
        return $m::findOrFail($id);
    }

    /**
     * Manage show profile request
     * @param integer $id
     * @return type
     */
    public function show($id) 
    {
        $this->middleware('permission:' . self::PERMISSION . ' show');

        $instance = $this->getOne($id);
        
        return $this->showResponse($instance);
    }

    /**
     * Manage store request
     * @param Request $request
     * @return type
     * @throws \Exception
     */
    public function store(Request $request) 
    {
        $this->middleware('permission:' . self::PERMISSION . ' store');

        $m = self::MODEL;
        try {
            $v = \Validator::make($request->all(), $this->validationRules);
            if ($v->fails()) {
                throw new \Exception("ValidationException");
            }
            $instance = $m::create($request->all());
            return $this->createdResponse($instance);
        } catch (\Exception $ex) {
            $data = ['form_validations' => $v->errors(), 'exception' => $ex->getMessage()];
            return $this->clientErrorResponse($data);
        }
    }

    /**
     * Manage update request
     * @param type $id
     * @param Request $request
     * @return type
     * @throws \Exception
     */
    public function update(Request $request, $id) 
    {
        $this->middleware('permission:' . self::PERMISSION . ' update');

        $m = self::MODEL;
        $instance = $m::findOrFail($id);

        try {
            $v = \Validator::make($request->all(), $this->validationRules);
            if ($v->fails()) {
                throw new \Exception("ValidationException");
            }
            $instance->fill($request->all());
            $instance->save();
            return $this->showResponse($instance);
        } catch (\Exception $ex) {
            $data = ['form_validations' => $v->errors(), 'exception' => $ex->getMessage()];
            return $this->clientErrorResponse($data);
        }
    }

    /**
     * Manage delete request
     * @param type $id
     * @return type
     */
    public function destroy($id) 
    {
        $this->middleware('permission:' . self::PERMISSION . ' destroy');

        $m = self::MODEL;
        $instance = $m::findOrFail($id);
        $instance->delete();

        return $this->deletedResponse();
    }
}