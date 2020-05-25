<?php

namespace App\Generators;

use Illuminate\Support\Str;
use Stichoza\GoogleTranslate\GoogleTranslate;

class Translation extends Generator
{
    protected $module;
    protected $nameModel;
    protected $jsonTrans = [];
    protected $tr;

    public function generate()
    {
        $this->tr = new GoogleTranslate();
        $this->tr->setSource();

        $lenguajes = [
            app()->getLocale(),
            'en'
        ];

        $this->module = strtolower($this->getModuleName());
        $this->nameModel = strtolower($this->getNameModel());

        foreach ($lenguajes as $locale) {
            $this->tr->setTarget($locale);
            $this->jsonTrans = [];
            //$nameFile = $locale . ".json";
            //$pathFile = $this->modulePath(['Resources', 'lang', $nameFile]);
            $translationsPath = resource_path("lang/{$locale}.json");

            $this->defineSingularAndPlural();
            $this->defineFieldLabels();

            $trans = $this->getJsonTrans($translationsPath);

            $this->writeFile($translationsPath, $trans);
        }
    }

    protected function getJsonTrans($translationsPath)
    {
        $trans = json_decode(file_get_contents($translationsPath), true);

        $trans[$this->module] = [
            $this->nameModel => $this->jsonTrans
        ];

        $trans = json_encode($trans, JSON_PRETTY_PRINT);

        return $trans;
    }

    protected function defineSingularAndPlural()
    {
        $this->addTrans('_singular', Str::singular($this->nameModel));
        $this->addTrans('_plural', Str::plural($this->nameModel));
    }

    protected function defineFieldLabels()
    {
        $fields = $this->getFields()->reject(function ($field) {
            return !isset($field['label']);
        });
        foreach ($fields as $content) {
            $this->addTrans($content['label'], $content['label']);
        }
        return $this->json;
    }

    protected function addTrans($key, $value)
    {
        $value = $this->traslate($value);
        $this->jsonTrans[$key] = $value;
    }

    protected function traslate($text)
    {
        return $this->tr->translate($text);
    }
}
