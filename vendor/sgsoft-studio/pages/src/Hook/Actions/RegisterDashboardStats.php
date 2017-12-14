<?php namespace WebEd\Base\Pages\Hook\Actions;

use WebEd\Base\Pages\Repositories\Contracts\PageRepositoryContract;
use WebEd\Base\Pages\Repositories\PageRepository;

class RegisterDashboardStats
{
    /**
     * @var PageRepository
     */
    protected $repository;

    public function __construct(PageRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function handle()
    {
        $count = $this->repository->count();
        echo view('webed-pages::admin.dashboard-stats.stat-box', [
            'count' => $count
        ]);
    }
}
