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
        $this->routeVue();
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

    protected function routeVue()
    {
        $this->routeVueModel();
        $this->routeVueIndex();
    }

    protected function routeVueModel()
    {
        $nameModel = strtolower($this->getNameModel());
        $nameModelPlural = Str::plural($nameModel);

        $contents = $this->view('scaffolding.routeVue', [
            'nameModel'       => $nameModel,
            'nameModelPlural' => $nameModelPlural,
        ]);

        $pathFile = $this->path(['resources', 'js', 'src', 'router', $nameModel . '.js']);

        $this->writeFile($pathFile, $contents);
    }

    protected function routeVueIndex()
    {
        $routePath = $this->path(['resources', 'js', 'src', 'router', 'index.js']);
        $routeContent = file_get_contents($routePath);
        $nameModel = strtolower($this->getNameModel());
        $stringRequire = "const $nameModel = require('./$nameModel.js')";
        $stringContent = "$nameModel.router,";
        //const generic = require('./generic.js')

        if (Str::contains($routeContent, $stringRequire)) {
            return;
        }

        $routeContent = str_replace('// requires', $stringRequire);
        $routeContent = $this->addNewContent('// requires', $stringRequire);
        $routeContent = $this->addNewContent('// content route', $stringContent, 4, "  ");
        $this->writeFile($routePath, $routeContent);
    }
}
