<?php namespace WebEd\Plugins\Miniprograms\Actions\Toubar\Stage;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\StageRepositoryContract;
use WebEd\Plugins\Miniprograms\Repositories\StageRepository;

class DeleteStageAction extends AbstractAction
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
     * @param $id
     * @param bool $force
     * @return array
     */
    public function run($id, $force = false)
    {
        $id = do_filter(BASE_FILTER_BEFORE_DELETE, $id, WEBED_TOUBAR_STAGE);

        $result = $this->repository->deleteStage($id, $force);

        do_action(BASE_ACTION_AFTER_DELETE, WEBED_TOUBAR_STAGE, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
