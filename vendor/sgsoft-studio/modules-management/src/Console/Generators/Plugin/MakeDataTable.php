<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Plugin;

use WebEd\Base\ModulesManagement\Console\Generators\PluginGeneratorTrait;

class MakeDataTable extends \WebEd\Base\ModulesManagement\Console\Generators\Core\MakeDataTable
{
    use PluginGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:make:datatable
    	{alias : The alias of the module}
    	{name : The class name}';
}
