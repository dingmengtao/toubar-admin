<?php namespace WebEd\Base\ModulesManagement\Console\Commands;

use Illuminate\Console\Command;
use WebEd\Base\ModulesManagement\Actions\ThemeVendorPublishAction;

class ThemeVendorPublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:vendor:publish {alias} {--tag=webed-public-assets} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vendor publish';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param ThemeVendorPublishAction $action
     */
    public function handle(ThemeVendorPublishAction $action)
    {
        $result = $action->run($this->argument('alias'), [
            '--tag' => $this->option('tag'),
            '--force' => $this->option('force'),
        ]);

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
