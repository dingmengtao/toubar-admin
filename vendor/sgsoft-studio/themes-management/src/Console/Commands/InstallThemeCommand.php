<?php namespace WebEd\Base\ThemesManagement\Console\Commands;

use Illuminate\Console\Command;
use WebEd\Base\ThemesManagement\Actions\InstallThemeAction;

class InstallThemeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:install {alias}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install WebEd theme';

    /**
     * Execute the console command.
     */
    public function handle(InstallThemeAction $action)
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
