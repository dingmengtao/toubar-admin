<?php namespace WebEd\Plugins\Miniprograms\Actions\Toubar\Investor;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\InvestorRepositoryContract;
use WebEd\Plugins\Miniprograms\Repositories\InvestorRepository;

class DeleteInvestorAction extends AbstractAction
{
    /**
     * @var InvestorRepository
     */
    protected $repository;

    public function __construct(InvestorRepositoryContract $repository)
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
        $id = do_filter(BASE_FILTER_BEFORE_DELETE, $id, WEBED_TOUBAR_INVESTOR);

        $result = $this->repository->deleteInvestor($id, $force);

        do_action(BASE_ACTION_AFTER_DELETE, WEBED_TOUBAR_INVESTOR, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
