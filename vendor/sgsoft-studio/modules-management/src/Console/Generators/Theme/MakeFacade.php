<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Theme;

use WebEd\Base\ModulesManagement\Console\Generators\ThemeGeneratorTrait;

class MakeFacade extends \WebEd\Base\ModulesManagement\Console\Generators\Core\MakeFacade
{
    use ThemeGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:make:facade
    	{name : The class name}';
}
