<?php

namespace App\Repositories\Cache;

use Illuminate\Cache\Repository;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\BaseRepository;

abstract class BaseCacheDecorator implements BaseRepository
{
    protected $repository;
    protected $cache;
    protected $entityName;
    protected $locale;

    protected $cacheTime;

    public function __construct()
    {
        $this->cache = app(Repository::class);
        $this->cacheTime = app(ConfigRepository::class)->get('cache.time', 60);
        $this->locale = app()->getLocale();
    }

    public function getModel()
    {
        return $this->repository->getModel();
    }

    public function find($id)
    {
        return $this->remember(function () use ($id) {
            return $this->repository->find($id);
        });
    }

    public function all()
    {
        return $this->remember(function () {
            return $this->repository->all();
        });
    }

    public function allWithBuilder() : Builder
    {
        return $this->remember(function () {
            return $this->repository->allWithBuilder();
        });
    }

    public function paginate(Array $data)
    {
        return $this->remember(function () use ($data) {
            return $this->repository->paginate($data);
        });
    }

    public function getData(array $data)
    {
        return $this->repository->getData($data);
    }

    public function create($data)
    {
        $this->cache->tags($this->entityName)->flush();

        return $this->repository->create($data);
    }

    public function update($model, $data)
    {
        $this->cache->tags($this->entityName)->flush();

        return $this->repository->update($model, $data);
    }

    public function destroy($model)
    {
        $this->cache->tags($this->entityName)->flush();

        return $this->repository->destroy($model);
    }

    public function findByAttributes(array $attributes)
    {
        return $this->remember(function () use ($attributes) {
            return $this->repository->findByAttributes($attributes);
        });
    }

    public function getByAttributes(array $attributes, $orderBy = null, $sortOrder = 'asc')
    {
        return $this->remember(function () use ($attributes, $orderBy, $sortOrder) {
            return $this->repository->getByAttributes($attributes, $orderBy, $sortOrder);
        });
    }

    public function findByMany(array $ids)
    {
        return $this->remember(function () use ($ids) {
            return $this->repository->findByMany($ids);
        });
    }

    public function clearCache()
    {
        $store = $this->cache;

        if (method_exists($this->cache->getStore(), 'tags')) {
            $store = $store->tags($this->entityName);
        }

        return $store->flush();
    }

    protected function remember(\Closure $callback, $key = null)
    {
        $cacheKey = $this->makeCacheKey($key);

        $store = $this->cache;

        if (method_exists($this->cache->getStore(), 'tags')) {
            $store = $store->tags([$this->entityName, 'global']);
        }

        return $store->remember($cacheKey, $this->cacheTime, $callback);
    }

    private function makeCacheKey($key = null): string
    {
        if ($key !== null) {
            return $key;
        }

        $cacheKey = $this->getBaseKey();

        $backtrace = debug_backtrace()[2];

        return sprintf("$cacheKey %s %s", $backtrace['function'], \serialize($backtrace['args']));
    }

    protected function getBaseKey(): string
    {
        return sprintf(
            'lioncore -locale:%s -entity:%s',
            $this->locale,
            $this->entityName
        );
    }
}
