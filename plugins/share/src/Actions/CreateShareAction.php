<?php namespace WebEd\Plugins\Share\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Share\Repositories\Contracts\ShareRepositoryContract;
use WebEd\Plugins\Share\Repositories\ShareRepository;

class CreateShareAction extends AbstractAction
{
    /**
     * @var ShareRepository
     */
    protected $repository;

    public function __construct(ShareRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $data)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_SHARE, 'create.post');

        $data['created_by'] = get_current_logged_user_id();

        $result = $this->repository->createShare($data);

        do_action(BASE_ACTION_AFTER_CREATE, WEBED_SHARE, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
