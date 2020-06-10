<?php

namespace App\Generators;

use Illuminate\Support\Str;

class Route extends Generator
{
    protected $routePath;
    public function generate()
    {
        $this->routePath    = $this->path(['Routes', 'api.php']);
        $this->routeLaravel();
        //$this->routeVue();
    }

    protected function routeLaravel()
    {
        $routeContent = file_get_contents($this->routePath);

        $nameRoute      = strtolower($this->getNameModel());
        $nameController = ucwords($this->getNameModel()) . "Controller";

        if (!Str::contains($routeContent, $nameController . '@index')) {
            $version = env('API_VERSION', 'v1');
            $routeContent .=
            "\n" .
            "Route::prefix('" . Str::plural($nameRoute) . "')->name('" . Str::plural($nameRoute) . ".')->group(function () {\n" .
            "    Route::get('/', '" . $nameController . "@index')->name('index')\n" .
            "        ->middleware('permission:$nameRoute');\n" .
            "    Route::get('/{" . $nameRoute . "}', '" . $nameController . "@show')->name('show')\n" .
            "        ->middleware('permission:$nameRoute show');\n" .
            "    Route::post('/', '" . $nameController . "@store')->name('store')\n" .
            "        ->middleware('permission:$nameRoute store');\n" .
            "    Route::put('/{" . $nameRoute . "}', '" . $nameController . "@update')->name('update')\n" .
            "        ->middleware('permission:$nameRoute update');\n" .
            "    Route::delete('/{" . $nameRoute . "}', '" . $nameController . "@destroy')->name('destroy')\n" .
            "        ->middleware('permission:$nameRoute destroy');\n" .
            "});";

            $this->writeFile($this->routePath, $routeContent);
        }
    }

    protected function routeVue()
    {
        $this->routePath    = base_path('resources\assets\js\router\routes.js');
        $routeContent = file_get_contents($this->routePath);
        $routeContent = explode("\r\n", $routeContent);

        $posApiResources = 0;
        $posApiResourcesEnd = 0;

        $nameRoute = strtolower($this->getNameModel());
        $nameRoutePlural = Str::of($nameRoute)->plural();
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

            $this->writeFile($this->routePath, $routeContent);
        }
    }
}
