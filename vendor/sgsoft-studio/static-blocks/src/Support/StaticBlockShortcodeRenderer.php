<?php namespace WebEd\Base\StaticBlocks\Support;

use WebEd\Base\StaticBlocks\Repositories\Contracts\StaticBlockRepositoryContract;
use WebEd\Base\StaticBlocks\Repositories\StaticBlockRepository;

class StaticBlockShortcodeRenderer
{
    /**
     * @var StaticBlockRepository
     */
    protected $repository;

    public function __construct(StaticBlockRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @var \WebEd\Base\Shortcode\Compilers\Shortcode $shortcode
     * @var string $content
     * @var \WebEd\Base\Shortcode\Compilers\ShortcodeCompiler $compiler
     * @var string $name
     * @return mixed|string
     */
    public function handle($shortcode, $content, $compiler, $name)
    {
        $block = $this->repository->findWhere([
            'slug' => $shortcode->alias,
        ]);
        if (!$block) {
            return null;
        }

        return $block->content;
    }
}
