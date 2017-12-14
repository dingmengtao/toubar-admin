<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Plugin;

use WebEd\Base\ModulesManagement\Console\Generators\PluginGeneratorTrait;

class MakeAction extends \WebEd\Base\ModulesManagement\Console\Generators\Core\MakeAction
{
    use PluginGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:make:action
    	{alias : The alias of the module}
    	{name : The class name}
    	{--type= : Action type}';
}
