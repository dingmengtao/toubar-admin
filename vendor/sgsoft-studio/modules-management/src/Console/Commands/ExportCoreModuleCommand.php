<?php namespace WebEd\Base\ModulesManagement\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Illuminate\Filesystem\Filesystem;

class ExportCoreModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:export {alias}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export core modules from vendor to core';

    /**
     * @var array
     */
    protected $container = [];

    /**
     * @var Composer
     */
    protected $composer;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Composer $composer, Filesystem $filesystem)
    {
        parent::__construct();

        $this->composer = $composer;
        $this->composer->setWorkingPath(base_path());

        $this->files = $filesystem;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->container['alias'] = $this->argument('alias');

        $module = get_core_module()
            ->where('alias', '=', $this->container['alias'])->first();

        if(!$module) {
            $this->error("Module not exists");
        }

        $moduleVendorPath = get_base_folder(array_get($module, 'file'));

        $relativePath = str_replace(base_path('vendor/sgsoft-studio/'), '', $moduleVendorPath);
        $relativePath = str_replace(webed_core_path(''), '', $relativePath);

        try {
            if (!$this->files->exists(webed_core_path($relativePath))) {
                $this->files->copyDirectory($moduleVendorPath, webed_core_path($relativePath));
            }

            $moduleJsonFile = webed_core_path($relativePath) . 'module.json';

            $moduleJson = json_decode(file_get_contents($moduleJsonFile), true);

            $moduleJson['version'] = isset($moduleJson['version']) ? $moduleJson['version'] : get_core_module_composer_version($moduleJson['repos']);

            file_put_contents($moduleJsonFile, json_encode_prettify($moduleJson));

            webed_core_modules()->modifyComposerAutoload(array_get($module, 'alias'), true);

            modules_management()->refreshComposerAutoload();

            $this->info("Module exported successfully.");
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}
