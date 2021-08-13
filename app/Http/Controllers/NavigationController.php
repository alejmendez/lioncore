<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use App\Traits\ApiResponse;
use App\Http\Requests\NavigationRequest;
use App\Http\Resources\NavigationCollection;
use App\Http\Resources\NavigationResource;
use App\Http\Resources\NavigationResourceMenu;
use App\Repositories\NavigationRepository;

class NavigationController extends BaseController
{
    use ApiResponse;

    public function __construct(NavigationRepository $navigationRepository)
    {
        $this->navigationRepository = $navigationRepository;
    }

    public function index()
    {
        $navigations = $this->navigationRepository->paginate(request()->all());
        return NavigationCollection::make($navigations);
    }

    public function show($id)
    {
        $navigation = $this->navigationRepository->find($id);
        return NavigationResource::make($navigation);
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

    public function store(NavigationRequest $request)
    {
        $navigation = $this->navigationRepository->create($request->all());
        return NavigationResource::make($navigation);
    }

    public function update(NavigationRequest $request, $id)
    {
        $navigation = $this->navigationRepository->update($id, $request->all());
        return NavigationResource::make($navigation);
    }

    public function destroy($id)
    {
        $this->navigationRepository->destroy($id);
        return $this->deletedResponse();
    }

    public function getMenu()
    {
        $navigation = $this->navigationRepository->getMenu();
        return NavigationResourceMenu::make($navigation);
    }
}
