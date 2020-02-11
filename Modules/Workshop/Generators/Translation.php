<?php

namespace Modules\Workshop\Generators;

class Translation extends Generator
{
    protected function generate()
    {
        $lenguajes = [
            app()->getLocale(),
            'en'
        ];

        $module = strtolower($this->module);
        $nameModel = strtolower($this->nameModel);

        foreach ($lenguajes as $locale) {
            $translationsPath = resource_path("lang/{$locale}.json");
            $json = json_decode(file_get_contents($translationsPath), true);

            if (!isset($json[$module])) {
                $json[$module] = [];
            }

            if (!isset($json[$module][$nameModel])) {
                $json[$module][$nameModel] = [];
            }

            $json[$module][$nameModel]['_singular'] = Str::singular($nameModel);
            $json[$module][$nameModel]['_plural'] = Str::plural($nameModel);

            foreach ($this->json as $content) {
                if (!isset($content['label'])) {
                    continue;
                }
                $json[$module][$nameModel][$content['label']] = $content['label'];
            }

            $translationsContent = json_encode($json, JSON_PRETTY_PRINT);
            $translationsContent = str_replace('    ', '  ', $translationsContent);

            File::put($translationsPath, $translationsContent);
        }
    }
}
