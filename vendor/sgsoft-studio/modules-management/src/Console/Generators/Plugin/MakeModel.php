<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Plugin;

use WebEd\Base\ModulesManagement\Console\Generators\PluginGeneratorTrait;

class MakeModel extends \WebEd\Base\ModulesManagement\Console\Generators\Core\MakeModel
{
    use PluginGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:make:model
    	{alias : The alias of the module}
    	{name : The class name}
    	{table : The table name}';
}
