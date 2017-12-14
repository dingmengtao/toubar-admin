<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Plugin;

use WebEd\Base\ModulesManagement\Console\Generators\PluginGeneratorTrait;

class MakeViewComposer extends \WebEd\Base\ModulesManagement\Console\Generators\Core\MakeViewComposer
{
    use PluginGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:make:composer
    	{alias : The alias of the module}
    	{name : The class name}';
}
