<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Theme;

use WebEd\Base\ModulesManagement\Console\Generators\ThemeGeneratorTrait;

class MakeCriteria extends \WebEd\Base\ModulesManagement\Console\Generators\Core\MakeCriteria
{
    use ThemeGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:make:criteria
    	{name : The class name}';
}
