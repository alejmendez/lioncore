<?php

namespace Modules\Workshop\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateGrud extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'workshop:generate-crud
                        {nameModel? : Name of the model}
                        {--module=? : Name of the module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generator crud.';

    /**
     * The name of the model.
     *
     * @var string
     */
    protected $nameModel = '';

    /**
     * The id of the model.
     *
     * @var string
     */
    protected $id;

    /**
     * The module of the model.
     *
     * @var string
     */
    protected $module;

    /**
     * The data of the model.
     *
     * @var string
     */
    protected $dataModel;

    /**
     * The title of the model.
     *
     * @var string
     */
    protected $title;

    /**
     * Path of the model.
     *
     * @var string
     */
    protected $pathCrudDef = 'app/CrudDef';

    /**
     * Path of the model.
     *
     * @var string
     */
    protected $inDB = false;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $models = $this->argument('nameModel');
        $models = explode(',', $models);
        $models = array_map('trim', $models);

        if (count($models) == 1) {
            if ($models[0] == '') {
                $models = [false];
            } elseif ($models[0] == 'all') {
                $models = $this->getAllModelsFiles();
            }
        }

        foreach ($models as $model) {
            $jsonContent = $this->getJsonContent($model);

            $this->generateMigration($jsonContent);
            $this->generateModel($jsonContent);
            // $this->generateFormRequest($jsonContent);
            $this->generateController($jsonContent);
            $this->generatePermissions($jsonContent);
            $this->generateViewVue($jsonContent);
            $this->generateRoute($jsonContent);
            $this->generateTranslations($jsonContent);
        }
    }

    protected function getAllModelsFiles()
    {
        $files = File::allFiles($this->pathCrudDef);
        $filesList = [];
        foreach ($files as $class) {
            if (!preg_match('/.json$/i', $class->getBasename())) {
                continue;
            }
            $filesList[] = str_replace('.json', '', $class->getBasename());
        }

        return $filesList;
    }

    protected function loadModel($nameModel)
    {
        $fileSelect = $this->pathCrudDef . '/' . $nameModel . '.json';
        $fileSelectContent = File::get($fileSelect);

        $fileSelectContent = collect(json_decode($fileSelectContent, true))
            ->map(function($ele) {
                 if (isset($ele['model'])) {
                    $this->dataModel = $ele;
                    $this->module = ucwords(strtolower($ele['module']));
                    $this->title = $ele['title'];
                    $this->inDB = $ele['inDB'];
                    return false;
                }

                if ($ele['name'] == 'id') {
                    $this->id = $ele;
                    return false;
                }

                return $ele;
            })
            ->reject(function ($ele) {
                return $ele === false;
            });

        return $fileSelectContent;
    }

    protected function getJsonContent($nameModel)
    {
        if (!$nameModel) {
            $filesList = $this->getAllModelsFiles();
            $filesList[] = "exit()";
            $nameModel = $this->choice(__('What model do I use?'), $filesList, 0);

            if ($nameModel == end($filesList)) {
                $this->info(__('goodbye'));
                exit;
            }
        }

        $this->nameModel = ucfirst(str_singular(strtolower($nameModel)));
        $this->info(__('Using the model') . ': ' . $nameModel);

        $fileSelectContent = $this->loadModel($nameModel);

        return $fileSelectContent;
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
            //dd($translationsContent);
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
}
