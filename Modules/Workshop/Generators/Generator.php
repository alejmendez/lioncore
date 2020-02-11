<?php

namespace Modules\Workshop\Generators;

use File;
abstract class Generator
{
    public function __construct($json)
    {
        $this->json = $json;
    }

    protected function modulePath($path)
    {
        if (is_array($path)) {
            $path = implode(DIRECTORY_SEPARATOR, $path);
        }
        return module_path($this->getModuleName(), $path);
    }

    protected function getNameModel()
    {
        return $this->json['model'];
    }

    protected function getModuleName()
    {
        return $this->json['module'];
    }

    protected function getFields()
    {
        return $this->json['fields'];
    }

    protected function view($view, $data)
    {
        return view('workshop::' . $view, $data)->render();
    }

    protected function writeFilePhp($pathFile, $contents)
    {
        $this->writeFile($pathFile, "<?php\n" . $contents);
    }

    protected function writeFile($pathFile, $contents)
    {
        File::put($pathFile, $contents);
    }
}
