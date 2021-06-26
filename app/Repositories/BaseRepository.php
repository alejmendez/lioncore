<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface CoreRepository
 * @package App\Repositories
 */
interface BaseRepository
{
    public function find($id);
    public function getModel();
    public function all();
    public function allWithBuilder() : Builder;
    public function paginate(Array $data);
    public function getData(Array $data);
    public function create($data);
    public function update($model, $data);
    public function destroy($model);
    public function findByAttributes(array $attributes);
    public function findByMany(array $ids);
    public function getByAttributes(array $attributes, $orderBy = null, $sortOrder = 'asc');
    public function clearCache();
}
