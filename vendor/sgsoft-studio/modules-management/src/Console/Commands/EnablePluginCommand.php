<?php namespace WebEd\Base\ModulesManagement\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use WebEd\Base\ModulesManagement\Actions\EnablePluginAction;

class EnablePluginCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:enable {alias}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enable plugin';

    /**
     * @param EnablePluginAction $action
     */
    public function handle(EnablePluginAction $action)
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
