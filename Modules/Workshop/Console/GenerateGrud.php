<?php

namespace Modules\Workshop\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Modules\Workshop\Generators\GeneratorCrud;

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
        $module = $this->argument('module');

        $generatorCrud = new GeneratorCrud($models, $module);
        $generatorCrud->run();
    }
}
