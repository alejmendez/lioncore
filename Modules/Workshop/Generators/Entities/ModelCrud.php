<?php

namespace Modules\Workshop\Generators\Entities;

use File;
use Module;
use Illuminate\Support\Str;

class ModelCrud
{
    protected $file;
    protected $module;
    protected $path;
    protected $fileName;
    protected $name;

    public function __construct($file, $module)
    {
        $this->setFile($file);
        $this->setModule($module->getName());
        $this->setPath($file->getPathname());
        $this->setFileName($file->getBasename());

        $ext = '.' . config('workshop.extCrudDef');
        $nameModel = str_replace($ext, '', $this->fileName);
        $nameModel = ucfirst(Str::singular(strtolower($nameModel)));
        $this->setName($nameModel);
    }

    public static function getAllModelsFiles()
    {
        $modules = Module::all();
        $filesList = [];
        $pathCrudDefInModules = config('workshop.pathCrudDefInModules');
        foreach ($modules as $module) {
            $pathCrud = $module->getPath() . '/' . $pathCrudDefInModules;
            if (!File::exists($pathCrud)) {
                continue;
            }

            $files = File::allFiles($pathCrud);
            foreach ($files as $class) {
                if (!preg_match('/.json$/i', $class->getBasename())) {
                    continue;
                }
                $model = new ModelCrud($class, $module);
                $filesList[$model->getName()] = $model;
            }
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
