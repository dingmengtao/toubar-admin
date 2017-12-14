<?php namespace WebEd\Base\Users\Console\Commands;

use Illuminate\Console\Command;
use WebEd\Base\Users\Repositories\Contracts\UserRepositoryContract;
use WebEd\Base\Users\Repositories\UserRepository;

class ResetPasswordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:reset-password {--restore}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset user password';

    /**
     * @param UserRepository $userRepository
     */
    public function handle(UserRepositoryContract $userRepository)
    {
        $user = $userRepository
            ->withTrashed()
            ->findWhere([
                'email' => $this->ask('Your email'),
            ]);

        if (!$user) {
            $this->error('User not exists with this email');

            return;
        }

        if ($this->option('restore')) {
            $userRepository->restore($user->id);
        }

        $result = $userRepository->update($user->id, [
            'password' => $this->secret('Your password'),
        ]);

        if ($result) {
            $this->info('OK!');
        } else {
            $this->error('Error occurred');
        }
    }
}
