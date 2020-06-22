<?php

namespace App\Generators;

use Illuminate\Support\Str;

use Stichoza\GoogleTranslate\GoogleTranslate;

class View extends Generator
{
    protected $jsonTrans = [];
    protected $tr;

    public function generate()
    {
        $this->generateRouteVue();
        $this->generateViewList();
        $this->generateViewForm();
        $this->generateStores();
        $this->generateTrans();
    }

    protected function generateRouteVue()
    {
        $this->generateRouteVueModel();
        $this->generateRouteVueIndex();
    }

    protected function generateRouteVueModel()
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

    protected function generateRouteVueIndex()
    {
        $routePath = $this->path(['resources', 'js', 'src', 'router', 'index.js']);
        $routeContent = file_get_contents($routePath);
        $nameModel = strtolower($this->getNameModel());
        $stringRequire = "const $nameModel = require('./$nameModel.js')";
        $stringContent = "...$nameModel.router,";

        if (Str::contains($routeContent, $stringRequire)) {
            return;
        }

        $routeContent = $this->addNewContent($routeContent, '// requires', $stringRequire);
        $routeContent = $this->addNewContent($routeContent, '// content route', $stringContent, 4, "  ");
        $this->writeFile($routePath, $routeContent);
    }

    protected function generateViewList()
    {
        $this->generateViewListDatatable();
        $this->generateViewListFilters();
        $this->generateViewListList();
    }

    protected function generateViewListDatatable()
    {
        $data = $this->getDataView();

        $contents = $this->view('scaffolding.views.list.datatable', $data);
        $pathFile = $this->path(['resources', 'js', 'src', 'views', $data['nameModel'], 'list', ucfirst($data['nameModel']) . 'DataTable.js']);
        $this->writeFile($pathFile, $contents);
    }

    protected function generateViewListFilters()
    {
        $data = $this->getDataView();

        $contents = $this->view('scaffolding.views.list.filters', $data);
        $pathFile = $this->path(['resources', 'js', 'src', 'views', $data['nameModel'], 'list', ucfirst($data['nameModel']) . 'Filters.js']);
        $this->writeFile($pathFile, $contents);
    }

    protected function generateViewListList()
    {
        $data = $this->getDataView();

        $contents = $this->view('scaffolding.views.list.list', $data);
        $pathFile = $this->path(['resources', 'js', 'src', 'views', $data['nameModel'], 'list', ucfirst($data['nameModel']) . 'List.js']);
        $this->writeFile($pathFile, $contents);
    }

    protected function generateViewForm()
    {
        $data = $this->getDataView();

        $contents = $this->view('scaffolding.views.form', $data);

        $pathFile = $this->path(['resources', 'js', 'src', 'views', $data['nameModel'], 'form', ucfirst($data['nameModel']) . 'Form.js']);
        $this->writeFile($pathFile, $contents);
    }

    protected function generateStores()
    {
        $this->generateStoresModule();
        $this->generateStoresState();
        $this->generateStoresMutations();
        $this->generateStoresActions();
        $this->generateStoresGetters();
    }

    protected function generateStoresModule()
    {
        $data = $this->getDataView();

        $contents = $this->view('scaffolding.views.store.module', $data);

        $pathFile = $this->path(['resources', 'js', 'src', 'store', $data['nameModel'], 'module' . ucfirst($data['nameModel']) . 'Management.js']);
        $this->writeFile($pathFile, $contents);
    }

    protected function generateStoresState()
    {
        $data = $this->getDataView();

        $contents = $this->view('scaffolding.views.store.state', $data);
        $pathFile = $this->path(['resources', 'js', 'src', 'store', $data['nameModel'], 'module' . ucfirst($data['nameModel']) . 'ManagementState.js']);
        $this->writeFile($pathFile, $contents);
    }

    protected function generateStoresMutations()
    {
        $data = $this->getDataView();

        $contents = $this->view('scaffolding.views.store.mutations', $data);
        $pathFile = $this->path(['resources', 'js', 'src', 'store', $data['nameModel'], 'module' . ucfirst($data['nameModel']) . 'ManagementMutations.js']);
        $this->writeFile($pathFile, $contents);
    }

    protected function generateStoresActions()
    {
        $data = $this->getDataView();

        $contents = $this->view('scaffolding.views.store.actions', $data);
        $pathFile = $this->path(['resources', 'js', 'src', 'store', $data['nameModel'], 'module' . ucfirst($data['nameModel']) . 'ManagementActions.js']);
        $this->writeFile($pathFile, $contents);
    }

    protected function generateStoresGetters()
    {
        $data = $this->getDataView();

        $contents = $this->view('scaffolding.views.store.getters', $data);
        $pathFile = $this->path(['resources', 'js', 'src', 'store', $data['nameModel'], 'module' . ucfirst($data['nameModel']) . 'ManagementGetters.js']);
        $this->writeFile($pathFile, $contents);
    }

    protected function getDataView()
    {
        $fields = $this->getFields();

        return [
            'nameModel'       => strtolower($this->getNameModel()),
            'nameModelPlural' => Str::plural(strtolower($this->getNameModel())),
            'fields'          => $fields
        ];
    }

    protected function generateTrans()
    {
        $data = $this->getDataView();
        $nameModel = $data['nameModel'];
        $nameModelPlural = $data['nameModelPlural'];

        $this->tr = new GoogleTranslate();
        $this->tr->setSource();

        $lenguajes = [
            'es'
        ];

        foreach ($lenguajes as $locale) {
            $this->tr->setTarget($locale);
            $this->jsonTrans = [];

            $this->defineTitles();
            $this->defineFieldLabels();

            $trans = json_encode($this->jsonTrans, JSON_PRETTY_PRINT);
            $trans = str_replace(['"', '    '], ['\'', '  '], $trans);
            $trans = preg_replace("/( {2,})\'([^\']+)\':/", "$1$2:", $trans);

            $contents = $this->view('scaffolding.views.trans', [
                'trans' => $trans
            ]);

            $pathFile = $this->path(['resources', 'js', 'src', 'i18n', 'trans', $locale, $nameModel . '.js']);
            $this->writeFile($pathFile, $contents);

            $transPath = $this->path(['resources', 'js', 'src', 'i18n', 'trans', $locale . '.js']);
            $stringImport = "import $nameModel from './es/$nameModel'";
            $stringContent = "$nameModel,";
            $transContent = file_get_contents($transPath);

            if (Str::contains($transContent, $stringImport)) {
                return;
            }

            $transContent = $this->addNewContent($transContent, '// imports', $stringImport);
            $transContent = $this->addNewContent($transContent, '// content trans', $stringContent, 1, "  ");
            $this->writeFile($transPath, $transContent);
        }
    }

    protected function defineTitles()
    {
        $nameModel = ucfirst(strtolower($this->getNameModel()));
        $titles = [
            'new'  => 'new ' . $nameModel,
            'list' => 'List ' . $nameModel,
            'view' => $nameModel,
            'edit' => 'Edit ' . $nameModel
        ];

        foreach ($titles as &$title) {
            $title = ucwords($this->traslate($title));
        }

        $this->jsonTrans['titles'] = $titles;
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
