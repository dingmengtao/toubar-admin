<?php namespace WebEd\Plugins\Blog\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
use WebEd\Plugins\Blog\Actions\Tags\CreateTagAction;

class GenerateSampleTagsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:faker:tags {--limit=10} {--refresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sample tags';

    /**
     * @var CreateTagAction
     */
    protected $action;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CreateTagAction $action)
    {
        parent::__construct();

        $this->action = $action;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('refresh')) {
            DB::table(webed_db_prefix() . 'tags')->delete();
        }

        Auth::guard(config('webed-auth.guard'))->loginUsingId(1);

        $faker = Factory::create();

        $limit = (int)$this->option('limit');
        $limit = $limit > 10000 ? 10000 : $limit;

        for ($i = 1; $i <= $limit; $i++) {
            $this->info('Creating tag #' . $i);
            $this->action->run([
                'title' => ucfirst($faker->unique()->name(4)),
                'slug' => str_slug($faker->unique()->name(4)),
                'status' => rand(0, 1),
                'is_featured' => rand(0, 1),
            ]);
        }
    }
}
