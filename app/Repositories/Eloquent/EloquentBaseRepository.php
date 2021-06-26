<?php

namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;

/**
 * Class EloquentCoreRepository
 *
 * @package App\Repositories\Eloquent
 */
abstract class EloquentBaseRepository implements BaseRepository
{
    /**
     * @var \Illuminate\Database\Eloquent\Model An instance of the Eloquent Model
     */
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        if ($this->model instanceof Model) {
            return $this->model->query();
        }

        return clone $this->model;
    }

    public function find($id)
    {
        return $this->getModel()->findOrFail($id);
    }

    public function all()
    {
        return $this->getModel()->orderBy('created_at', 'DESC')->get();
    }

    public function allWithBuilder(): Builder
    {
        return $this->getModel()->query();
    }

    public function paginate(Array $data)
    {
        $perPage = $data['per_page'] ?? 15;
        return $this->getModel()
            ->filter($data)
            ->paginateFilter($perPage)
            ->withQueryString();
    }

    public function getData(array $data)
    {
        return $data;
    }

    public function create($data)
    {
        $data = $this->getData($data);
        return $this->getModel()->create($data);
    }

    public function update($id, $data)
    {
        $data = $this->getData($data);
        $instance = $this->find($id);
        $instance->update($data);
        return $instance;
    }

    public function destroy($id)
    {
        $instance = $this->find($id);
        return $instance->delete();
    }

    public function findByAttributes(array $attributes)
    {
        $query = $this->buildQueryByAttributes($attributes);

        return $query->first();
    }

    public function getByAttributes(array $attributes, $orderBy = null, $sortOrder = 'asc')
    {
        $query = $this->buildQueryByAttributes($attributes, $orderBy, $sortOrder);

        return $query->get();
    }

    /**
     * Build Query to catch resources by an array of attributes and params
     * @param  array $attributes
     * @param  null|string $orderBy
     * @param  string $sortOrder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function buildQueryByAttributes(array $attributes, $orderBy = null, $sortOrder = 'asc')
    {
        $query = $this->allWithBuilder();

        foreach ($attributes as $field => $value) {
            $query = $query->where($field, $value);
        }

        if (null !== $orderBy) {
            $query->orderBy($orderBy, $sortOrder);
        }

        return $query;
    }

    public function findByMany(array $ids)
    {
        $query = $this->allWithBuilder();

        return $query->whereIn("id", $ids)->get();
    }

    public function clearCache()
    {
        return true;
    }
}
