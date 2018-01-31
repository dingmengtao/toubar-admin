<?php namespace WebEd\Plugins\Miniprograms\Actions\Toubar\Trade;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\TradeRepositoryContract;
use WebEd\Plugins\Miniprograms\Repositories\TradeRepository;

class CreateTradeAction extends AbstractAction
{
    /**
     * @var TradeRepository
     */
    protected $repository;

    public function __construct(TradeRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @return array
     */
    public function run(array $data)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_TOUBAR_TRADE, 'create.post');

        $data['created_by'] = get_current_logged_user_id();
        $data['updated_by'] = get_current_logged_user_id();

        $result = $this->repository->createTrade($data);

        do_action(BASE_ACTION_AFTER_CREATE, WEBED_TOUBAR_TRADE, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
