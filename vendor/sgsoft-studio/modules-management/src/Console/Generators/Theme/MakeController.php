<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Theme;

use WebEd\Base\ModulesManagement\Console\Generators\ThemeGeneratorTrait;

class MakeController extends \WebEd\Base\ModulesManagement\Console\Generators\Core\MakeController
{
    use ThemeGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:make:controller
    	{name : The class name}
    	{--admin : Generate front controller}
    	{--resource : Generate a controller with route resource}';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('admin')) {
            if ($this->option('resource')) {
                return __DIR__ . '/../../../../resources/stubs/controllers/controller.resource.stub';
            }

            return __DIR__ . '/../../../../resources/stubs/controllers/controller.stub';
        }

        if ($this->option('resource')) {
            return __DIR__ . '/../../../../resources/stubs/controllers/front/controller.resource.stub';
        }

        return __DIR__ . '/../../../../resources/stubs/controllers/front/controller.stub';
    }
}
