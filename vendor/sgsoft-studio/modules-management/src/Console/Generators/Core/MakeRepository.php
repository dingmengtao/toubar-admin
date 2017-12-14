<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Core;

use WebEd\Base\ModulesManagement\Console\Generators\AbstractCoreGenerator;

class MakeRepository extends AbstractCoreGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:make:repository
    	{alias : The alias of the module}
    	{name : The class name}
    	{--no-cache : Generate this repository without repository caching}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    protected $buildStep;

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        $nameInput = $this->getNameInput();

        $name = $this->parseName($nameInput);

        $path = $this->getPath($name . 'Repository');

        if ($this->alreadyExists($nameInput)) {
            $this->error($this->type . ' already exists!');

            return false;
        }

        /**
         * Make repository
         */
        $this->makeDirectory($path);
        $this->files->put($path, $this->buildClass($name));

        /**
         * Make cache decorator
         */
        $this->buildStep = 'make-cache-decorator';
        $pathCacheDecorator = $this->getPath($name . 'RepositoryCacheDecorator');
        $this->makeDirectory($pathCacheDecorator);
        $this->files->put($pathCacheDecorator, $this->buildClass($name . 'Repository'));

        /**
         * Create model contract
         */
        $this->buildStep = 'make-contract';
        $contractName = 'Contracts/' . get_file_name($path, '.php');
        $contractPath = get_base_folder($path) . $contractName . 'Contract.php';

        $this->makeDirectory($contractPath);

        $this->files->put($contractPath, $this->buildClass('Repositories\\' . $contractName));

        $this->info($this->type . ' created successfully.');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->buildStep === 'make-contract') {
            return __DIR__ . '/../../../../resources/stubs/repositories/repository.contract.stub';
        }
        if ($this->buildStep === 'make-cache-decorator' && !$this->option('no-cache')) {
            return __DIR__ . '/../../../../resources/stubs/repositories/repository.cache-decorator.stub';
        }
        if ($this->option('no-cache')) {
            return __DIR__ . '/../../../../resources/stubs/repositories/repository.no-cache.stub';
        }
        return __DIR__ . '/../../../../resources/stubs/repositories/repository.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        if ($this->buildStep === 'make-contract') {
            return 'Repositories\\Contracts\\' . $this->argument('name');
        }
        return 'Repositories\\' . $this->argument('name');
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string $stub
     * @param  string $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $class = class_basename($this->getNameInput());

        return str_replace('DummyClass', $class, $stub);
    }
}
