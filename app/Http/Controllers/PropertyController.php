<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use App\Traits\ApiResponse;
use App\Http\Requests\PropertyRequest;
use App\Http\Resources\PropertyCollection;
use App\Http\Resources\PropertyResource;
use App\Repositories\PropertyRepository;

class PropertyController extends BaseController
{
    use ApiResponse;

    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    public function index()
    {
        $properties = $this->propertyRepository->paginate(request()->all());
        return PropertyCollection::make($properties);
    }

    public function show($id)
    {
        $property = $this->propertyRepository->find($id);
        return PropertyResource::make($property);
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

    public function store(PropertyRequest $request)
    {
        $property = $this->propertyRepository->create($request->all());
        return PropertyResource::make($property);
    }

    public function update(PropertyRequest $request, $id)
    {
        $property = $this->propertyRepository->update($id, $request->all());
        return PropertyResource::make($property);
    }

    public function destroy($id)
    {
        $this->propertyRepository->destroy($id);
        return $this->deletedResponse();
    }
}
