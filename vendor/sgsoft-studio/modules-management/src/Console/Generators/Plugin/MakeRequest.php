<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Plugin;

use WebEd\Base\ModulesManagement\Console\Generators\PluginGeneratorTrait;

class MakeRequest extends \WebEd\Base\ModulesManagement\Console\Generators\Core\MakeRequest
{
    use PluginGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:make:request
    	{alias : The alias of the module}
    	{name : The class name}';
}
