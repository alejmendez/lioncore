<?php

namespace Modules\Workshop\Generators;

use File;
use Module;

use Modules\Workshop\Generators\Interfaces\Generator;
use Modules\Workshop\Console\GenerateGrud;
use Modules\Workshop\Generators\Entities\ModelCrud;

use Illuminate\Support\Str;
use Maklad\Permission\Models\Role;
use Maklad\Permission\Models\Permission;

use App\Models\Form;
use App\Models\Field;

class GeneratorCrud implements Generator
{
    protected $models;
    protected $module;
    protected $console;

    protected $nameModel = '';
    protected $id;
    protected $dataModel;
    protected $title;
    protected $pathCrudDef = 'CrudDef';
    protected $inDB = false;

    public function __construct(String $models, String $module, GenerateGrud $console = null)
    {
        $this->console = $console;
        $this->initVars($models, $module);
    }

    public function initVars(String $models, String $module)
    {
        $this->models = explode(',', $models);
        $this->models = array_map('trim', $this->models);

        $this->module = $module;

        if (count($this->models) == 1) {
            if ($this->models[0] == '') {
                $this->models = [false];
            } elseif ($this->models[0] == 'all') {
                $this->models = $this->getAllModelsFiles();
            }
        }
    }

    public function run()
    {
        foreach ($this->models as $model) {
            $jsonContent = $this->getJsonContent($model);

            $this->generateMigration($jsonContent);
            $this->generateModel($jsonContent);
            $this->generateFormRequest($jsonContent);
            $this->generateController($jsonContent);
            $this->generatePermissions($jsonContent);
            $this->generateViewVue($jsonContent);
            $this->generateRoute($jsonContent);
            $this->generateTranslations($jsonContent);
        }
    }

    protected function getAllModelsFiles()
    {
        return ModelCrud::getAllModelsFiles();
    }

    protected function getJsonContent($nameModel)
    {
        $model = null;
        $files = $this->getAllModelsFiles();
        if (!$nameModel) {
            $filesList = [];
            $exit = "exit()";

            foreach ($files as $file) {
                $filesList[] = $file->getName();
            }

            $filesList[] = $exit;
            $nameModel = $this->choice(__('What model do I use?'), $filesList);

            if ($nameModel == $exit) {
                $this->exit();
            }
        }

        if (!isset($files[$nameModel])) {
            return false;
        }

        $model = $files[$nameModel];
        $this->info(__('Using the model') . ': ' . $model->getName());

        $fileSelectContent = $this->loadModel($model);
        dd($fileSelectContent);
        return $fileSelectContent;
    }

    protected function loadModel($model)
    {
        $fileSelectContent = File::get($model->getPath());
        $jsonContent = json_decode($fileSelectContent, true);
        return $jsonContent;
    }

    protected function generateMigration($jsonContent)
    {
        $this->info(__('Generating Migration'));

        if ($this->inDB) {
            $this->generateMigrationDB($jsonContent);
        } else {
            $this->generateMigrationFile($jsonContent);
        }
    }

    protected function generateMigrationFile($jsonContent)
    {
        $contents = view('scaffolding.migration', [
            'id' => $this->id,
            'nameModel' => $this->nameModel,
            'jsonContent' => $jsonContent
        ])->render();

        $contents = "<?php\n" . $contents;
        $date = $this->dataModel['dateMigration'] ?? date('Y_m_d_His');
        $nameFile = $date . "_create_" . Str::plural(strtolower($this->nameModel)) . "_table.php";
        $pathFile = $this->getMigrationPath() . DIRECTORY_SEPARATOR . $nameFile;

        File::put($pathFile, $contents);
    }

    protected function generateMigrationDB($jsonContent)
    {
        $form = Form::whereName(strtolower($this->nameModel))->first();
        if (!$form) {
            $form = Form::create([
                'name' => strtolower($this->nameModel)
            ]);
        }

        $form->fields()->forcedelete();
        $fields = [];

        foreach ($jsonContent as $field) {
            $fields[] = Field::create($field);
        }

        $form->fields()->saveMany($fields);
    }

    protected function generateModel($jsonContent)
    {
        $this->info(__('Generating Model'));

        $fillable = $jsonContent->pluck('fieldInput.name')->reject(function ($value, $key) {
            return $value == 'id';
        })->map(function ($name) {
            return "'$name'";
        })->implode(',');

        $contents = view('scaffolding.model', [
            'nameModel'   => $this->nameModel,
            'fillable'    => $fillable,
            'jsonContent' => $jsonContent
        ])->render();

        $contents = "<?php\n" . $contents;
        $nameFile = ucwords($this->nameModel) . ".php";
        $pathFile = app_path('Models') . DIRECTORY_SEPARATOR . $nameFile;

        File::put($pathFile, $contents);
    }

    protected function generateFormRequest($jsonContent)
    {
        $this->info(__('Generating FormRequest'));

        $jsonContent  = $jsonContent->reject(function ($value, $key) {
            return $value['name'] == 'id' || $value['validations'] == '';
        });

        $contents = view('scaffolding.formRequest', [
            'nameModel' => $this->nameModel,
            'jsonContent' => $jsonContent
        ])->render();

        $contents = "<?php\n" . $contents;
        $nameFile = ucwords($this->nameModel) . "Request.php";
        $pathFile = app_path('Http/Requests') . DIRECTORY_SEPARATOR . $nameFile;

        File::put($pathFile, $contents);
    }

    protected function generateController($jsonContent)
    {
        $this->info(__('Generating Controller'));

        $validations  = $jsonContent->reject(function ($value, $key) {
            return $value['name'] == 'id' || $value['validations'] == '';
        });

        $fieldsSelect = $jsonContent->pluck('name');
        $fieldsSelect = json_encode($fieldsSelect);
        $fieldsSelect = str_replace(",", ", ", $fieldsSelect);

        $contents = view('scaffolding.controller', [
            'nameModel'    => $this->nameModel,
            'jsonContent'  => $jsonContent,
            'fieldsSelect' => $fieldsSelect,
            'validations'  => $validations
        ])->render();

        $contents = "<?php\n" . $contents;
        $nameFile = ucwords($this->nameModel) . "Controller.php";
        $pathFile = app_path('Http/Controllers/' . ucwords($this->module)) . DIRECTORY_SEPARATOR . $nameFile;

        File::put($pathFile, $contents);
    }

    protected function generatePermissions($jsonContent)
    {
        $this->info(__('Generating Permissions'));

        $permission = strtolower($this->nameModel);

        $permissions = [
            $permission,
            $permission . ' show',
            $permission . ' store',
            $permission . ' update',
            $permission . ' destroy'
        ];

        try {
            Permission::findByName($permission);

            foreach ($permissions as $permission) {
                Permission::create([
                    'name'       => $permission,
                    'guard_name' => 'api'
                ]);
            }

            Role::findByName('admin')->givePermissionTo($permissions);
        } catch (\Maklad\Permission\Exceptions\PermissionAlreadyExists $e) {
            return true;
        } catch (\Maklad\Permission\Exceptions\PermissionDoesNotExist $e) {
            return true;
        }
    }

    protected function generateViewVue($jsonContent)
    {
        $this->info(__('Generating View'));

        $this->generateViewList($jsonContent);
        $this->generateViewForm($jsonContent);
    }

    protected function generateViewList($jsonContent)
    {
        $fieldsSelect = $jsonContent->pluck('fieldInput.name')
            ->map(function ($name) {
                return "'$name'";
            })->implode(',');

        $contents = view('scaffolding.views.list', [
            'title' => $this->title,
            'module' => $this->module,
            'nameModel' => $this->nameModel,
            'jsonContent' => $jsonContent,
            'fieldsSelect' => $fieldsSelect
        ])->render();

        $path = resource_path('assets/js/pages/' . ucwords($this->module) . '/' . strtolower(str_plural($this->nameModel)));
        $pathFile = $path . '/list.vue';

        if (!is_dir($path)) {
            @mkdir($path, 0777, true);
        }

        File::put($pathFile, $contents);
    }

    protected function generateViewForm($jsonContent)
    {
        $fieldsSelect = $jsonContent->pluck('fieldInput.name')
            ->map(function ($name) {
                return "'$name'";
            })->implode(',');

        $contents = view('scaffolding.views.form', [
            'title' => $this->title,
            'module' => $this->module,
            'nameModel' => $this->nameModel,
            'jsonContent' => $jsonContent,
            'fieldsSelect' => $fieldsSelect
        ])->render();

        $pathFile = resource_path('assets/js/pages/' . ucwords($this->module) . '/' . strtolower(str_plural($this->nameModel)) . '/form.vue');

        File::put($pathFile, $contents);
    }

    protected function generateRoute($jsonContent)
    {
        $this->info(__('Generating Routes'));
        $routePath    = base_path('routes\api.php');
        $routeContent = file_get_contents($routePath);
        $routeContent = explode("\n", $routeContent);

        $posApiResources    = 0;
        $posApiResourcesEnd = 0;

        $nameRoute      = strtolower($this->nameModel);
        $nameController = ucwords($this->nameModel) . "Controller";
        $newContent     = "'$nameRoute' => '{}\{$nameController}',";
        $newContent     = "'" . $nameRoute . "' => '" . $this->module . "\\" . $nameController . "',";
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

            File::put($routePath, $routeContent);
        }

        // Route Vue
        $routePath    = base_path('resources\assets\js\router\routes.js');
        $routeContent = file_get_contents($routePath);
        $routeContent = explode("\r\n", $routeContent);

        $posApiResources = 0;
        $posApiResourcesEnd = 0;

        $nameRoute = strtolower($this->nameModel);
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

            File::put($routePath, $routeContent);
        }

    }

    protected function generateTranslations($jsonContent)
    {
        $lenguajes = [
            app()->getLocale(),
            'en'
        ];

        $module = strtolower($this->module);
        $nameModel = strtolower($this->nameModel);

        foreach ($lenguajes as $locale) {
            $this->info(__('Generating Translations') . ': ' . $locale);
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

            foreach ($jsonContent as $content) {
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
    /**
     * Get the path to the migration directory.
     *
     * @return string
     */
    protected function getMigrationPath()
    {
        return $this->laravel->databasePath().DIRECTORY_SEPARATOR.'migrations';
    }

    /**
     * Give the user a single choice from an array of answers.
     *
     * @param  string  $question
     * @param  array  $choices
     * @param  string|null  $default
     * @param  mixed|null  $attempts
     * @param  bool|null  $multiple
     * @return string
     */
    public function choice($question, array $choices, $default = null, $attempts = null, $multiple = null)
    {
        return $this->console->choice($question, $choices, $default, $attempts, $multiple);
    }

    /**
     * Write a string as information output.
     *
     * @param  string  $string
     * @param  int|string|null  $verbosity
     * @return void
     */
    public function info($string, $verbosity = null)
    {
        $this->console->info($string, $verbosity);
    }

    /**
     * Write a string as error output.
     *
     * @param  string  $string
     * @param  int|string|null  $verbosity
     * @return void
     */
    public function error($string, $verbosity = null)
    {
        $this->console->error($string, $verbosity);
    }

    public function exit()
    {
        $this->info(__('goodbye'));
        exit;
    }
}
