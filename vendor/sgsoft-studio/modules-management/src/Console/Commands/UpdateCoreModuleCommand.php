<?php namespace WebEd\Base\ModulesManagement\Console\Commands;

use Illuminate\Console\Command;
use WebEd\Base\ModulesManagement\Actions\UpdateCoreModuleAction;

class UpdateCoreModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:update {alias}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update WebEd core';

    /**
     * @param UpdateCoreModuleAction $action
     */
    public function handle(UpdateCoreModuleAction $action)
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
