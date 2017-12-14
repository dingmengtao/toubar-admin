<?php namespace WebEd\Base\ThemesManagement\Console\Commands;

use Illuminate\Console\Command;
use WebEd\Base\ThemesManagement\Actions\UpdateThemeAction;

class UpdateThemeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:update {alias}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update WebEd theme';

    /**
     * Execute the console command.
     */
    public function handle(UpdateThemeAction $action)
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
