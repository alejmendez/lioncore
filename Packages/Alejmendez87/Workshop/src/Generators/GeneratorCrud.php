<?php

namespace Alejmendez87\Workshop\Generators;

use Illuminate\Support\Facades\File;

use Alejmendez87\Workshop\Console\GenerateGrud;
use Alejmendez87\Workshop\Generators\Interfaces\Generator;
use Alejmendez87\Workshop\Generators\Entities\ModelCrud;

use Alejmendez87\Workshop\Generators\Migration;
use Alejmendez87\Workshop\Generators\Model;
use Alejmendez87\Workshop\Generators\FormRequest;
use Alejmendez87\Workshop\Generators\Controller;
use Alejmendez87\Workshop\Generators\Permission;
use Alejmendez87\Workshop\Generators\View;
use Alejmendez87\Workshop\Generators\Route;
use Alejmendez87\Workshop\Generators\Translation;

class GeneratorCrud implements Generator
{
    protected $models;
    protected $console;

    protected $allOptionsActive = false;
    protected $listOptions = [
        'migration',
        'model',
        'formrequest',
        'controller',
        'permissions',
        'view',
        'route',
        'translations',
        'factory',
        'test',
    ];

    public function __construct(String $models, GenerateGrud $console = null)
    {
        $this->console = $console;
        $this->initVars($models);
    }

    public function initVars(String $models)
    {
        $this->models = explode(',', $models);
        $this->models = array_map('trim', $this->models);

        if (count($this->models) == 1) {
            if ($this->models[0] == '') {
                $this->models = [false];
            } elseif ($this->models[0] == 'all') {
                $this->models = $this->getAllModelsFiles();
            }
        }

        $cantOptions = 0;
        foreach ($this->listOptions as $option) {
            if ($this->getOption($option)) {
                $cantOptions++;
            }
        }
        $this->allOptionsActive = $cantOptions === 0;
    }

    public function run()
    {
        foreach ($this->models as $model) {
            $json = $this->getJsonContent($model);

            $this->generateMigration($json);
            $this->generateModel($json);
            $this->generateFormRequest($json);
            $this->generateController($json);
            $this->generateRepository($json);
            $this->generatePermissions($json);
            $this->generateViewVue($json);
            $this->generateRoute($json);
            $this->generateTranslations($json);
            $this->generateFactory($json);
            $this->generateTest($json);
        }
    }

    protected function getAllModelsFiles()
    {
        $filesList = [];
        $pathCrudDef = config('workshop.pathCrudDef');
        $pathCrud = base_path($pathCrudDef);
        if (!File::exists($pathCrud)) {
            return $filesList;
        }

        $files = File::allFiles($pathCrud);
        $extModelsFile = config('workshop.extCrudDef');
        $regexFile = '/.' . $extModelsFile . '$/i';
        foreach ($files as $file) {
            if (!preg_match($regexFile, $file->getBasename())) {
                continue;
            }
            $model = new ModelCrud($file);
            $filesList[$model->getName()] = $model;
        }

        return $filesList;
    }

    protected function getJsonContent($nameModel)
    {
        $model = null;
        $files = $this->getAllModelsFiles();
        if (!$nameModel) {
            $filesList = [];
            $exit = '* ' . trans('workshop.exit');

            foreach ($files as $file) {
                $filesList[] = $file->getName();
            }

            $filesList[] = $exit;
            $nameModel = $this->choice(trans('workshop.what_model_do_i_use'), $filesList);

            if ($nameModel == $exit) {
                $this->exit();
            }
        }

        if (!isset($files[$nameModel])) {
            $this->error(trans('workshop.the_model_not_exist'));
            exit();
        }

        $model = $files[$nameModel];
        $this->info(trans('workshop.using_the_model') . ': ' . $model->getName());

        $fileSelectContent = $this->loadModel($model);

        return $fileSelectContent;
    }

    protected function loadModel($model)
    {
        $fileSelectContent = File::get($model->getPath());
        $json = json_decode($fileSelectContent, true);

        if (!isset($json['id'])) {
            $id = collect($json['fields'])->firstWhere('primary', true);
            $json['id'] = $id ? $id['name'] : 'id';
        }

        return $json;
    }

    protected function generateMigration($json)
    {
        if (!$this->getOption('migration')) return;
        $this->info(trans('workshop.generating_migration'));
        $generator = new Migration($json);
        $generator->generate();
    }

    protected function generateModel($json)
    {
        if (!$this->getOption('model')) return;
        $this->info(trans('workshop.generating_model'));
        $generator = new Model($json);
        $generator->generate();
    }

    protected function generateFormRequest($json)
    {
        if (!$this->getOption('formrequest')) return;
        $this->info(trans('workshop.generating_formrequest'));
        $generator = new FormRequest($json);
        $generator->generate();
    }

    protected function generateController($json)
    {
        if (!$this->getOption('controller')) return;
        $this->info(trans('workshop.generating_controller'));
        $generator = new Controller($json);
        $generator->generate();
    }

    protected function generateRepository($json)
    {
        if (!$this->getOption('repository')) return;
        $this->info(trans('workshop.generating_repository'));
        $generator = new Repository($json);
        $generator->generate();
    }

    protected function generatePermissions($json)
    {
        if (!$this->getOption('permissions')) return;
        $this->info(trans('workshop.generating_permissions'));
        $generator = new Permission($json);
        $generator->generate();
    }

    protected function generateViewVue($json)
    {
        if (!$this->getOption('view')) return;
        $this->info(trans('workshop.generating_view'));
        $generator = new View($json);
        $generator->generate();
    }

    protected function generateRoute($json)
    {
        if (!$this->getOption('route')) return;
        $this->info(trans('workshop.generating_routes'));
        $generator = new Route($json);
        $generator->generate();
    }

    protected function generateTranslations($json)
    {
        if (!$this->getOption('translations')) return;
        $this->info(trans('workshop.generating_translations'));
        $generator = new Translation($json);
        $generator->generate();
    }

    protected function generateFactory($json)
    {
        if (!$this->getOption('factory')) return;
        $this->info(trans('workshop.generating_factory'));
        $generator = new Factory($json);
        $generator->generate();
    }

    protected function generateTest($json)
    {
        if (!$this->getOption('test')) return;
        $this->info(trans('workshop.generating_test'));
        $generator = new Test($json);
        $generator->generate();
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
    public function choice($question, array $choices, $default = null, $maxAttempts = null, $allowMultipleSelections = false)
    {
        return $this->console->choice($question, $choices, $default, $maxAttempts, $allowMultipleSelections);
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
        $this->info(trans('workshop.goodbye'));
        exit;
    }

    protected function getOption($option)
    {
        return $this->allOptionsActive ? true : $this->console->option($option);
    }
}
