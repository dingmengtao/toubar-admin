<?php namespace WebEd\Plugins\Miniprograms\Actions\Toubar\Investor;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\InvestorRepositoryContract;
use WebEd\Plugins\Miniprograms\Repositories\InvestorRepository;

class CreateInvestorAction extends AbstractAction
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
     * @param array $data
     * @param array $trades
     * @return array
     */
    public function run(array $data, array $trades)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_TOUBAR_INVESTOR, 'create.post');

        $data['created_by'] = get_current_logged_user_id();
        $data['updated_by'] = get_current_logged_user_id();

        $result = $this->repository->createInvestor($data,$trades);

        do_action(BASE_ACTION_AFTER_CREATE, WEBED_TOUBAR_INVESTOR, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
