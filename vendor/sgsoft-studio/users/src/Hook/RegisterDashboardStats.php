<?php namespace WebEd\Base\Users\Hook;

use WebEd\Base\Users\Repositories\Contracts\UserRepositoryContract;
use WebEd\Base\Users\Repositories\UserRepository;

class RegisterDashboardStats
{
    /**
     * @var UserRepository
     */
    protected $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function handle()
    {
        echo view('webed-users::admin.dashboard-stats.stat-box', [
            'count' => $this->repository->count(),
        ]);
    }
}
