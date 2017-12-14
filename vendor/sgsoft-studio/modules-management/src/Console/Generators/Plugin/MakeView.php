<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Plugin;

use WebEd\Base\ModulesManagement\Console\Generators\PluginGeneratorTrait;

class MakeView extends \WebEd\Base\ModulesManagement\Console\Generators\Core\MakeView
{
    use PluginGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:make:view
    	{alias : The alias of the module}
    	{name : View name}
    	{--layout=1columns : Layout type}';
}
