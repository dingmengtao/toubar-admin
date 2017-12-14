<?php namespace WebEd\Base\ModulesManagement\Console\Commands;

use Illuminate\Console\Command;
use WebEd\Base\ModulesManagement\Actions\UninstallPluginAction;

class UninstallPluginCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:uninstall {alias}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall WebEd plugin';

    /**
     * Execute the console command.
     */
    public function handle(UninstallPluginAction $action)
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
