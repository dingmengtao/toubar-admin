<?php namespace WebEd\Base\ModulesManagement\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use WebEd\Base\ModulesManagement\Actions\DisablePluginAction;

class DisablePluginCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:disable {alias}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable plugin';

    /**
     * @param DisablePluginAction $action
     */
    public function handle(DisablePluginAction $action)
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
