<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Core;

use WebEd\Base\ModulesManagement\Console\Generators\AbstractCoreGenerator;

class MakeController extends AbstractCoreGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:make:controller
    	{alias : The alias of the module}
    	{name : The class name}
    	{--front : Generate front controller}
    	{--resource : Generate a controller with route resource}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('front')) {
            if ($this->option('resource')) {
                return __DIR__ . '/../../../../resources/stubs/controllers/front/controller.resource.stub';
            }

            return __DIR__ . '/../../../../resources/stubs/controllers/front/controller.stub';
        }

        if ($this->option('resource')) {
            return __DIR__ . '/../../../../resources/stubs/controllers/controller.resource.stub';
        }

        return __DIR__ . '/../../../../resources/stubs/controllers/controller.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'Http\\Controllers\\' . $this->argument('name') . 'Controller';
    }

    protected function replaceParameters(&$stub)
    {
        $stub = str_replace([
            '{alias}',
        ], [
            $this->argument('alias'),
        ], $stub);
    }
}
