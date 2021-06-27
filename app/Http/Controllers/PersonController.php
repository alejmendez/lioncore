<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use App\Traits\ApiResponse;
use App\Http\Requests\PersonRequest;
use App\Http\Resources\PersonCollection;
use App\Http\Resources\PersonResource;
use App\Repositories\PersonRepository;

class PersonController extends BaseController
{
    use ApiResponse;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function index()
    {
        $people = $this->personRepository->paginate(request()->all());
        return PersonCollection::make($people);
    }

    public function show($id)
    {
        $person = $this->personRepository->find($id);
        return PersonResource::make($person);
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

    public function store(PersonRequest $request)
    {
        $person = $this->personRepository->create($request->all());
        return PersonResource::make($person);
    }

    public function update(PersonRequest $request, $id)
    {
        $person = $this->personRepository->update($id, $request->all());
        return PersonResource::make($person);
    }

    public function destroy($id)
    {
        $this->personRepository->destroy($id);
        return $this->deletedResponse();
    }
}
