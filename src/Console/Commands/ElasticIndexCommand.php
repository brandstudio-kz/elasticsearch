<?php

namespace BrandStudio\Elasticsearch\Console\Commands;

use Illuminate\Console\Command;

class ElasticIndexCommand extends Command
{

        /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'brandstudio:elastic {operation} {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elasticsearch [create, drop, migrate] index';

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
        $operation_name = $this->argument('operation');
        $model = "App\\".$this->argument('model');

        $operation = ucfirst($operation_name);
        $class = "BrandStudio\\Elasticsearch\\Console\\Operations\\{$operation}Index";

        if (!class_exists($class)) {
            throw new \Exception("Invalid '{$operation_name}' operation! Supported operations: ['create', 'drop', 'migrate']");
        }
        if (!class_exists($model)) {
            throw new \Exception("{$model} not found!");
        }
        $class::execute($model);
    }

}
