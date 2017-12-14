<?php namespace WebEd\Base\Users\Console\Commands;

use Illuminate\Console\Command;
use WebEd\Base\ACL\Repositories\Contracts\RoleRepositoryContract;
use WebEd\Base\ACL\Repositories\RoleRepository;
use WebEd\Base\Users\Repositories\Contracts\UserRepositoryContract;
use WebEd\Base\Users\Repositories\UserRepository;

class CreateSuperAdminUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new super admin';

    /**
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     */
    public function handle(UserRepositoryContract $userRepository, RoleRepositoryContract $roleRepository)
    {
        $user = $userRepository->findWhereOrCreate([
            'username' => $this->ask('Your username'),
            'email' => $this->ask('Your email'),
        ], [
            'password' => $this->secret('Your password'),
            'display_name' => $this->ask('Your display name', 'Super Admin'),
            'first_name' => $this->ask('Your first name', 'Admin'),
            'last_name' => $this->ask('Your last name', false),
        ]);

        $superAdminRole = $roleRepository->findWhere([
            'slug' => 'super-admin',
        ]);

        $userRepository->syncRoles($user->id, [
            $superAdminRole->id,
        ]);

        $this->info('OK!');
    }
}
