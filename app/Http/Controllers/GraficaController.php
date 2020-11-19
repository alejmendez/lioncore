<?php
namespace App\Http\Controllers;

// Control Base
use App\Http\Controllers\Controller as BaseController;

// Traits
use App\Traits\ApiResponse;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\GraficaRequest;

// Modelos
use App\Models\Grafica;

use DataTables;

class GraficaController extends BaseController
{
    use ApiResponse;

    public function index()
    {
        $query = Grafica::select('title');
        return DataTables::of($query)->make(true);
    }

    public function filters()
    {
        $filters = [];

        return $this->showResponse($filters);
    }

    public function moduleData()
    {
        $moduleData = [];

        return $this->showResponse($moduleData);
    }

    public function show($id)
    {
        $instance = Grafica::findOrFail($id);
        return $this->showResponse($instance);
    }

    public function store(GraficaRequest $request)
    {
        $instance = Grafica::create($request->all());
        return $this->createdResponse($instance);
    }

    public function update(GraficaRequest $request, $id)
    {
        $instance = Grafica::findOrFail($id);
        $instance->fill($request->all());
        $instance->save();
        return $this->showResponse($instance);
    }

    public function destroy($id)
    {
        $instance = Grafica::findOrFail($id);
        $instance->delete();
        return $this->deletedResponse();
    }
}
