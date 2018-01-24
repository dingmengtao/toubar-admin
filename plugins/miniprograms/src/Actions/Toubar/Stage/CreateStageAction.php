<?php namespace WebEd\Plugins\Miniprograms\Actions\Toubar\Stage;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\StageRepositoryContract;
use WebEd\Plugins\Miniprograms\Repositories\StageRepository;

class CreateStageAction extends AbstractAction
{
    /**
     * @var StageRepository
     */
    protected $repository;

    public function __construct(StageRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @return array
     */
    public function run(array $data)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_TOUBAR_STAGE, 'create.post');

        $data['created_by'] = get_current_logged_user_id();

        $result = $this->repository->createStage($data);

        do_action(BASE_ACTION_AFTER_CREATE, WEBED_TOUBAR_STAGE, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
