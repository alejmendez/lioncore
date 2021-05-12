<?php

namespace Alejmendez87\Workshop\Generators;

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

        $nameRoute       = strtolower($this->getNameModel());
        $nameRoutePlural = Str::plural($nameRoute);
        $nameController  = ucwords($this->getNameModel()) . "Controller";

        if (Str::contains($routeContent, $nameController . '::class')) {
            //return;
        }

        $newRoute = "\n" .
        "Route::prefix('" . $nameRoutePlural . "')->name('" . $nameRoutePlural . ".')->group(function () {\n" .
        "    Route::middleware('permission:$nameRoute  read')->group(function () {\n" .
        "        Route::get('/', [" . $nameController . "::class, 'index'])->name('index');\n" .
        "        Route::get('/filters', [" . $nameController . "::class, 'filters'])->name('filters');\n" .
        "        Route::get('/module-data', [" . $nameController . "::class, 'moduleData'])->name('module-data');\n" .
        "        Route::get('/{id}', [" . $nameController . "::class, 'show'])->name('show');\n" .
        "    });\n" .
        "    Route::post('/', [" . $nameController . "::class, 'store]')->name('store')\n" .
        "        ->middleware('permission:$nameRoute store');\n" .
        "    Route::put('/{id}', [" . $nameController . "::class, 'update]')->name('update')\n" .
        "        ->middleware('permission:$nameRoute update');\n" .
        "    Route::delete('/{id}', [" . $nameController . "::class, 'destroy]')->name('destroy')\n" .
        "        ->middleware('permission:$nameRoute delete');\n" .
        "});";

        $routeContent = $this->addNewContent($routeContent, '// add router', $newRoute, 5, '    ');

        $this->writeFile($this->routePath, $routeContent);
    }
}
