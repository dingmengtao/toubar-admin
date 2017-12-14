<?php namespace WebEd\Base\ModulesManagement\Console\Commands;

use Illuminate\Console\Command;
use WebEd\Base\ModulesManagement\Actions\UpdatePluginAction;

class UpdatePluginCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:update {alias}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update WebEd plugin';

    /**
     * @param UpdatePluginAction $action
     */
    public function handle(UpdatePluginAction $action)
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
