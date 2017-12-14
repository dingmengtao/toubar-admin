<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Plugin;

use WebEd\Base\ModulesManagement\Console\Generators\PluginGeneratorTrait;

class MakeController extends \WebEd\Base\ModulesManagement\Console\Generators\Core\MakeController
{
    use PluginGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:make:controller
    	{alias : The alias of the module}
    	{name : The class name}
    	{--front : Generate front controller}
    	{--resource : Generate a controller with route resource}';
}
