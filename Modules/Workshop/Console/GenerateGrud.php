<?php

namespace Modules\Workshop\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Modules\Workshop\Generators\GeneratorCrud;

class GenerateGrud extends Command
{
    protected $signature = 'workshop:generate-crud
        {nameModel? : Name of the model}
        {module? : Name of the module}
        {--i|migration}
        {--m|model}
        {--o|formrequest}
        {--c|controller}
        {--p|permissions}
        {--w|viewvue}
        {--r|route}
        {--t|translations}
        {--f|factory}
        {--e|test}
    ';

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
        $models = (String) $this->argument('nameModel');
        $module = (String) $this->argument('module');

        $generatorCrud = new GeneratorCrud($models, $module, $this);
        $generatorCrud->run();
    }
}
