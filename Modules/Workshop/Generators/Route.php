<?php

namespace Modules\Workshop\Generators;

class Route extends Generator
{
    protected function generate()
    {
        $routePath    = base_path('routes\api.php');
        $routeContent = file_get_contents($routePath);
        $routeContent = explode("\n", $routeContent);

        $posApiResources    = 0;
        $posApiResourcesEnd = 0;

        $nameRoute      = strtolower($this->getNameModel());
        $nameController = ucwords($this->getNameModel()) . "Controller";
        $newContent     = "'$nameRoute' => '{}\{$nameController}',";
        $newContent     = "'" . $nameRoute . "' => '" . $this->getModuleName() . "\\" . $nameController . "',";
        $addNewContent  = true;

        foreach ($routeContent as $line => $content) {
            if (strpos($content, 'Route::apiResources(') !== false) {
                $posApiResources = $line;
            }

            if (strpos(preg_replace('/\s+/', ' ', $content), $newContent) !== false) {
                $addNewContent = false;
                break;
            }

            if ($posApiResources !== 0 && strpos($content, ']);') !== false) {
                $posApiResourcesEnd = $line;
                break;
            }
        }

        if ($addNewContent) {
            array_splice($routeContent, $posApiResourcesEnd, 0, ["        $newContent"]);
            $routeContent = implode("\r\n", $routeContent);

            $this->writeFile($routePath, $routeContent);
        }

        // Route Vue
        $routePath    = base_path('resources\assets\js\router\routes.js');
        $routeContent = file_get_contents($routePath);
        $routeContent = explode("\r\n", $routeContent);

        $posApiResources = 0;
        $posApiResourcesEnd = 0;

        $nameRoute = strtolower($this->getNameModel());
        $nameRoutePlural = str_plural($nameRoute);
        $newContent =  "    { path: '/$nameRoutePlural', name: '$nameRoutePlural', component: require('~/pages/core/$nameRoutePlural/list.vue') },\r\n";
        $newContent .= "    { path: '/$nameRoute/:id?', name: '$nameRoute', component: require('~/pages/core/$nameRoutePlural/form.vue') },";

        $addNewContent = true;

        foreach ($routeContent as $line => $content) {
            if (strpos($content, '...authGuard([') !== false) {
                $posApiResources = $line;
            }

            if (strpos(preg_replace('/\s+/', ' ', $content), "/$nameRoute/:id?") !== false) {
                $addNewContent = false;
                break;
            }

            if ($posApiResources !== 0 && strpos($content, ']),') !== false) {
                $posApiResourcesEnd = $line;
                break;
            }
        }

        if ($addNewContent) {
            array_splice($routeContent, $posApiResourcesEnd, 0, [$newContent]);
            $routeContent = implode("\r\n", $routeContent);

            $this->writeFile($routePath, $routeContent);
        }
    }
}
