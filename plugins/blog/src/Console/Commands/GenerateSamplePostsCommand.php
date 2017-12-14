<?php namespace WebEd\Plugins\Blog\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use WebEd\Plugins\Blog\Actions\Posts\CreatePostAction;
use Faker\Factory;

class GenerateSamplePostsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:faker:posts {--limit=10} {--refresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sample posts';

    /**
     * @var CreatePostAction
     */
    protected $action;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CreatePostAction $action)
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
            DB::table(webed_db_prefix() . 'posts')->delete();
        }

        Auth::guard(config('webed-auth.guard'))->loginUsingId(1);

        $faker = Factory::create();

        $limit = (int)$this->option('limit');
        $limit = $limit > 10000 ? 10000 : $limit;

        $categories = collect(get_categories())->pluck('id')->toArray();

        for ($i = 1; $i <= $limit; $i++) {
            $this->info('Creating post #' . $i);
            $this->action->run([
                'title' => ucfirst($faker->unique()->text(150)),
                'slug' => str_slug($faker->unique()->text(100)),
                'description' => $faker->sentence(20),
                'content' => nl2br($faker->paragraphs(150, true)),
                'status' => rand(0, 1),
                'is_featured' => rand(0, 1),
                'category_id' => $faker->randomElement($categories),
                'thumbnail' => $faker->imageUrl(600, 400, 'cats', true, 'Faker'),
            ]);
        }
    }
}
