<?php

namespace App\Generators\Entities;

use File;
use Illuminate\Support\Str;

class ModelCrud
{
    protected $file;
    protected $path;
    protected $fileName;
    protected $name;

    public function __construct($file)
    {
        $this->setFile($file);
        $this->setPath($file->getPathname());
        $this->setFileName($file->getBasename());

        $ext = '.' . config('workshop.extCrudDef');
        $nameModel = str_replace($ext, '', $this->fileName);
        $nameModel = ucfirst(Str::singular(strtolower($nameModel)));
        $this->setName($nameModel);
    }

    public static function getAllModelsFiles()
    {
        $filesList = [];
        $pathCrudDef = config('workshop.pathCrudDef');
        $pathCrud = app_path($pathCrudDef);
        if (!File::exists($pathCrud)) {
            return $filesList;
        }

        $files = File::allFiles($pathCrud);
        foreach ($files as $file) {
            if (!preg_match('/.json$/i', $file->getBasename())) {
                continue;
            }
            $model = new ModelCrud($file);
            $filesList[$model->getName()] = $model;
        }

        return $filesList;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function setModule($module)
    {
        $this->module = $module;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return '[' . $this->module . '] ' . $this->name;
    }
}
