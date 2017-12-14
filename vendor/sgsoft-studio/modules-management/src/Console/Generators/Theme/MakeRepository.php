<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Theme;

use WebEd\Base\ModulesManagement\Console\Generators\ThemeGeneratorTrait;

class MakeRepository extends \WebEd\Base\ModulesManagement\Console\Generators\Core\MakeRepository
{
    use ThemeGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:make:repository
    	{name : The class name}
    	{--no-cache : Generate this repository without repository caching}';
}
