<?php namespace WebEd\Base\ModulesManagement\Console\Commands;

use Illuminate\Console\Command;

class GetAllPluginsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all plugins information';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modules = get_plugin();

        $header = ['Name', 'Alias', 'Version', 'Namespace', 'Autoload type'];
        $result = [];
        foreach ($modules as $module) {
            $result[] = [
                array_get($module, 'name'),
                array_get($module, 'alias'),
                array_get($module, 'version'),
                array_get($module, 'namespace'),
                array_get($module, 'autoload'),
            ];
        }

        $this->table($header, $result);
    }
}
