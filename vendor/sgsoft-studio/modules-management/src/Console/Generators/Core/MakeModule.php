<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Core;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeModule extends Command
{
    /**
     * @var string
     */
    protected $signature = 'module:create 
        {alias : The alias of the module}
    ';

    /**
     * @var string
     */
    protected $description = 'WebEd modules generator.';

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * Array to store the configuration details.
     *
     * @var array
     */
    protected $container = [];

    /**
     * Accepted module types
     * @var array
     */
    protected $acceptedTypes = [
        'core' => 'Base',
        'plugins' => 'Plugins',
    ];

    protected $moduleType;

    protected $moduleFolderName;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->files = $filesystem;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->moduleType = $this->ask('Your module type. Eccepted: core, plugins. Other types will return "plugins".', 'plugins');
        if (!in_array($this->moduleType, array_keys($this->acceptedTypes))) {
            $this->moduleType = 'plugins';
        }

        $this->container['alias'] = str_slug($this->argument('alias'));

        $this->step1();
    }

    protected function step1()
    {
        $this->moduleFolderName = str_slug($this->ask('Module folder name:', $this->container['alias']));
        $this->container['name'] = $this->ask('Name of module:', 'WebEd ' . $this->container['alias']);
        $this->container['author'] = $this->ask('Author of module:');
        $this->container['description'] = $this->ask('Description of module:', $this->container['name']);
        $this->container['namespace'] = $this->ask('Namespace of module:', 'WebEd\\' . $this->acceptedTypes[$this->moduleType] . '\\' . studly_case($this->container['alias']));
        $this->container['version'] = $this->ask('Module version.', '1.0');
        $this->container['autoload'] = $this->ask('Autoload type.', 'psr-4');
        $this->container['require'] = new \stdClass();

        $this->step2();
    }

    protected function step2()
    {
        $this->generatingModule();

        $this->info("\nYour module generated successfully.");
    }

    protected function generatingModule()
    {
        $pathType = $this->makeModuleFolder();
        $directory = $pathType($this->moduleFolderName);

        $source = __DIR__ . '/../../../../resources/stubs/_folder-structure';

        /**
         * Make directory
         */
        $this->files->makeDirectory($directory);
        $this->files->copyDirectory($source, $directory, null);

        /**
         * Replace files placeholder
         */
        $files = $this->files->allFiles($directory);
        foreach ($files as $file) {
            $contents = $this->replacePlaceholders($file->getContents());
            $filePath = $pathType($this->moduleFolderName . '/' . $file->getRelativePathname());

            $this->files->put($filePath, $contents);
        }

        /**
         * Modify the module.json information
         */
        \File::put($directory . '/module.json', json_encode_prettify($this->container));
    }

    protected function makeModuleFolder()
    {
        switch ($this->moduleType) {
            case 'core':
                if (!$this->files->isDirectory(webed_core_path())) {
                    $this->files->makeDirectory(webed_core_path());
                }
                return 'webed_core_path';
                break;
            case 'plugins':
            default:
                if (!$this->files->isDirectory(webed_plugins_path())) {
                    $this->files->makeDirectory(webed_plugins_path());
                }
                return 'webed_plugins_path';
                break;
        }
    }

    protected function replacePlaceholders($contents)
    {
        $find = [
            'DummyNamespace',
            'DummyAlias',
            'DummyName',
            'DummyType',
        ];

        $replace = [
            $this->container['namespace'],
            $this->container['alias'],
            $this->container['name'],
            $this->moduleType,
        ];

        return str_replace($find, $replace, $contents);
    }
}
