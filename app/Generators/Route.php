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
    }

    protected function routeLaravel()
    {
        $routeContent = file_get_contents($this->routePath);

        $nameRoute      = strtolower($this->getNameModel());
        $nameController = ucwords($this->getNameModel()) . "Controller";

        if (Str::contains($routeContent, $nameController . '@index')) {
            return;
        }

        $newRoute = "\n" .
        "Route::prefix('" . Str::plural($nameRoute) . "')->name('" . Str::plural($nameRoute) . ".')->group(function () {\n" .
        "\t\t    Route::get('/', '" . $nameController . "@index')->name('index')\n" .
        "\t\t        ->middleware('permission:$nameRoute');\n" .
        "\t\t    Route::get('/', '" . $nameController . "@filters')->name('filters')\n" .
        "\t\t        ->middleware('permission:$nameRoute');\n" .
        "\t\t    Route::get('/', '" . $nameController . "@moduleData')->name('module-data')\n" .
        "\t\t        ->middleware('permission:$nameRoute');\n" .
        "\t\t    Route::get('/{" . $nameRoute . "}', '" . $nameController . "@show')->name('show')\n" .
        "\t\t        ->middleware('permission:$nameRoute show');\n" .
        "\t\t    Route::post('/', '" . $nameController . "@store')->name('store')\n" .
        "\t\t        ->middleware('permission:$nameRoute store');\n" .
        "\t\t    Route::put('/{" . $nameRoute . "}', '" . $nameController . "@update')->name('update')\n" .
        "\t\t        ->middleware('permission:$nameRoute update');\n" .
        "\t\t    Route::delete('/{" . $nameRoute . "}', '" . $nameController . "@destroy')->name('destroy')\n" .
        "\t\t        ->middleware('permission:$nameRoute destroy');\n" .
        "\t\t});" .
        "\t\t// add router";
        $routeContent = str_replace('// add router', $newRoute);

        $this->writeFile($this->routePath, $routeContent);
    }
}
