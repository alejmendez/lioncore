<?php

namespace Alejmendez87\Workshop\Generators;

use Illuminate\Support\Facades\File;

abstract class Generator
{
    public function __construct($json)
    {
        $this->json = $json;
    }

    protected function path($path)
    {
        if (is_array($path)) {
            $path = implode(DIRECTORY_SEPARATOR, $path);
        }
        return base_path($path);
    }

    protected function getNameModel()
    {
        return $this->json['model'];
    }

    protected function getModelPluralName()
    {
        return $this->json['modelPluralName'];
    }

    protected function getFields()
    {
        return collect($this->json['fields']);
    }

    protected function getFieldsWithoutId()
    {
        return $this->getFields()->reject(function ($field) {
            return $field['name'] == 'id';
        });
    }

    protected function view($view, $data)
    {
        return view('workshop::' . $view, $data)->render();
    }

    protected function addNewContent($routeContent, $search, $newContent, $tabBase = 0, $tabChar = "\t")
    {
        $tabs = str_repeat($tabChar, $tabBase);
        $newContent = collect(explode("\n", $newContent))->map(function($line) use($tabs) {
            return $tabs . $line;
        })->join("\n");
        $newContent = $newContent . "\n" . $tabs . $search;
        return str_replace($tabs . $search, $newContent, $routeContent);
    }

    protected function writeFilePhp($pathFile, $contents)
    {
        $this->writeFile($pathFile, "<?php\n" . $contents);
    }

    protected function writeFile($pathFile, $contents)
    {
        $dir = substr($pathFile, 0, strrpos($pathFile, DIRECTORY_SEPARATOR));
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        File::put($pathFile, $contents);
    }
}
