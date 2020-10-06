<?php

namespace App\Generators;

use Illuminate\Support\Str;

class Route extends Generator
{
    protected $routePath;
    public function generate()
    {
        $this->routePath    = $this->path(['Routes', 'api.php']);
        $this->route();
    }

    protected function route()
    {
        $routeContent = file_get_contents($this->routePath);

        $nameRoute      = strtolower($this->getNameModel());
        $nameController = ucwords($this->getNameModel()) . "Controller";

        if (Str::contains($routeContent, $nameController . '@index')) {
            return;
        }

        $newRoute = "\n" .
        "Route::prefix('" . Str::plural($nameRoute) . "')->name('" . Str::plural($nameRoute) . ".')->group(function () {\n" .
        "            Route::get('/', '" . $nameController . "@index')->name('index')\n" .
        "                ->middleware('permission:$nameRoute list');\n" .
        "            Route::get('/filters', '" . $nameController . "@filters')->name('filters')\n" .
        "                ->middleware('permission:$nameRoute list');\n" .
        "            Route::get('/module-data', '" . $nameController . "@moduleData')->name('module-data')\n" .
        "                ->middleware('permission:$nameRoute list');\n" .
        "            Route::get('/{" . $nameRoute . "}', '" . $nameController . "@show')->name('show')\n" .
        "                ->middleware('permission:$nameRoute show');\n" .
        "            Route::post('/', '" . $nameController . "@store')->name('store')\n" .
        "                ->middleware('permission:$nameRoute store');\n" .
        "            Route::put('/{" . $nameRoute . "}', '" . $nameController . "@update')->name('update')\n" .
        "                ->middleware('permission:$nameRoute update');\n" .
        "            Route::delete('/{" . $nameRoute . "}', '" . $nameController . "@destroy')->name('destroy')\n" .
        "                ->middleware('permission:$nameRoute destroy');\n" .
        "        });";

        $routeContent = $this->addNewContent($routeContent, '// add router', $newRoute, 2, '    ');

        $this->writeFile($this->routePath, $routeContent);
    }
}
