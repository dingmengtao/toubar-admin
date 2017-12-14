<?php namespace WebEd\Base\ThemesManagement\Console\Commands;

use Illuminate\Console\Command;

class GetAllThemesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all themes information';

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $themes = get_all_theme_information();

        $header = ['Name', 'Alias', 'Version', 'Namespace', 'Autoload type'];
        $result = [];
        foreach ($themes as $theme) {
            $result[] = [
                array_get($theme, 'name'),
                array_get($theme, 'alias'),
                array_get($theme, 'version'),
                array_get($theme, 'namespace'),
                array_get($theme, 'autoload'),
            ];
        }

        $this->table($header, $result);
    }
}
