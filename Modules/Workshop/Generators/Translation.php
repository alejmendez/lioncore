<?php

namespace Modules\Workshop\Generators;

use Str;

class Translation extends Generator
{
    protected $module;
    protected $nameModel;

    public function generate()
    {
        $lenguajes = [
            app()->getLocale(),
            'en'
        ];

        $this->module = strtolower($this->getModuleName());
        $this->nameModel = strtolower($this->getNameModel());

        foreach ($lenguajes as $locale) {
            //$nameFile = $locale . ".json";
            //$pathFile = $this->modulePath(['Resources', 'lang', $nameFile]);
            $translationsPath = resource_path("lang/{$locale}.json");

            $json = $this->initJson($translationsPath);
            $json = $this->defineSingularAndPlural($json);
            $json = $this->defineFieldLabels($json);

            $translationsContent = json_encode($json, JSON_PRETTY_PRINT);
            $translationsContent = str_replace('    ', '  ', $translationsContent);

            $this->writeFile($translationsPath, $translationsContent);
        }
    }

    protected function initJson($translationsPath)
    {
        $json = json_decode(file_get_contents($translationsPath), true);

        if (!isset($json[$this->module])) {
            $json[$this->module] = [];
        }

        if (!isset($json[$this->module][$this->nameModel])) {
            $json[$this->module][$this->nameModel] = [];
        }

        return $json;
    }

    protected function defineSingularAndPlural($json)
    {
        $json[$this->module][$this->nameModel]['_singular'] = Str::singular($this->nameModel);
        $json[$this->module][$this->nameModel]['_plural'] = Str::plural($this->nameModel);
        return $json;
    }

    protected function defineFieldLabels($json)
    {
        $fields = $this->getFields();
        foreach ($fields as $content) {
            if (!isset($content['label'])) {
                continue;
            }
            $json[$this->module][$this->nameModel][$content['label']] = $content['label'];
        }
        return $json;
    }
}
