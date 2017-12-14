<?php namespace WebEd\Base\ModulesManagement\Console\Commands;

use Illuminate\Console\Command;
use WebEd\Base\ModulesManagement\Actions\InstallPluginAction;

class InstallPluginCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:install {alias}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install WebEd plugin';

    /**
     * @var array
     */
    protected $container = [];

    /**
     * Execute the console command.
     */
    public function handle(InstallPluginAction $action)
    {
        $result = $action->run($this->argument('alias'));

        if($result['error']) {
            foreach ($result['messages'] as $message) {
                $this->error($message);
            }
        } else {
            foreach ($result['messages'] as $message) {
                $this->info($message);
            }
        }
    }
}
